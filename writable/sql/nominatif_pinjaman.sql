select * from(
      SELECT
      pinjaman.nomor_registrasi,
      kode_product,
      pinjaman.nomor_rekening,
      nama_depan nama_debitur,
      saldo_tunggakan_pokok,
      saldo_tunggakan_bunga,
      ( saldo_tunggakan_pokok + saldo_tunggakan_bunga ) total_tunggakan,
      nilai_fasilitas_asal,
      saldo_pinjaman_pokok,
      GREATEST( IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_pokok, '%Y%m%d' ) ), 0 ),
      IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_bunga, '%Y%m%d' ) ), 0 ) ) hari_tunggak,
      CASE
        WHEN GREATEST( IFNULL(DATEDIFF(date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE(tgl_mulai_tunggakan_pokok, '%Y%m%d' ) ), 0 ),
        IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_bunga, '%Y%m%d' ) ), 0 ) ) < 31 THEN '0-30'
        WHEN GREATEST( IFNULL( DATEDIFF(date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_pokok, '%Y%m%d' ) ), 0 ),
        IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_bunga, '%Y%m%d' ) ), 0 ) ) < 91 THEN '31-90'
        WHEN GREATEST( IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_pokok, '%Y%m%d' ) ), 0 ),
        IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_bunga, '%Y%m%d' ) ), 0 ) ) < 181 THEN '91-180'
        WHEN GREATEST( IFNULL( DATEDIFF( STR_TO_DATE(@posisiData, '%Y%m%d'), STR_TO_DATE( tgl_mulai_tunggakan_pokok, '%Y%m%d' ) ), 0 ),
        IFNULL( DATEDIFF( date_add(STR_TO_DATE(@posisiData, '%Y%m%d'),interval 1 day), STR_TO_DATE( tgl_mulai_tunggakan_bunga, '%Y%m%d' ) ), 0 ) ) < 361 THEN '181-360'
        ELSE '>360'
      END bucket_dpd,
      CASE
        metode_hitung_bunga WHEN 'FLAT' THEN 'FLAT'
        ELSE 'NON FLAT'
      END jenis_suku_bunga,
      percent_bunga_kontraktual / 100 suku_bunga,
      CONVERT(tgl_mulai_fasilitas,
      DATE) tgl_mulai,
      STR_TO_DATE(tgl_akhir_fasilitas,
      '%Y%m%d') tgl_akhir,
      TIMESTAMPDIFF( YEAR,
      STR_TO_DATE(tgl_mulai_fasilitas,
      '%Y%m%d'),
      STR_TO_DATE(tgl_akhir_fasilitas,
      '%Y%m%d') ) thnPinjaman,
      kode_kantor,
      IFNULL(kode_kolektibilitas_effektif, 1) kode_kolektibilitas_effektif,
      IFNULL(provisi.outstanding_provisi, 0) provisi,
      IFNULL(tlm.outstanding_tlm, 0) biaya_tlm,
      IFNULL(rest.outstanding_rest, 0) bunga_restruktur,
      CASE
        WHEN kode_product IN ('KM05', 'KI05')
        and tgl_akhir_fasilitas >= @posisiData THEN nilai_fasilitas_asal -nilai_fasilitas_blokir- saldo_pinjaman_pokok
        ELSE 0
      END kelonggaran_tarik,
      offset_agunan,
      saldo_accrual_bunga_performing + saldo_accrual_bunga_non_performing saldo_accrual,
      status_fasilitas,
      kode_pihak_terkait,
      nilai_fasilitas_blokir,
      is_restruk_covid
    FROM
      (
      SELECT
        nomor_rekening,
        tgl_mulai_fasilitas,
        tgl_akhir_fasilitas,
        status_fasilitas,
        nilai_fasilitas_asal,
        nilai_fasilitas_blokir,
        percent_bunga_kontraktual,
        tglstatus
      FROM
        (
        SELECT
          nomor_rekening norek,
          MAX(tgl_mulai_fasilitas) mulai,
          MAX(tgl_status_fasilitas) tglstatus
        FROM
          tblfasilitas
        WHERE
          tgl_status_fasilitas <= @posisiData
        GROUP BY
          nomor_rekening) a
      INNER JOIN tblfasilitas b ON
        a.norek = b.nomor_rekening
        AND a.mulai = b.tgl_mulai_fasilitas
        AND a.tglstatus = b.tgl_status_fasilitas
        AND b.record_status = 'valid') fasilitas
    INNER JOIN (
      SELECT
        *
      FROM
        tblpinjaman
      WHERE
        tgl_pembukaan <= @posisiData) pinjaman ON
      pinjaman.nomor_rekening = fasilitas.nomor_rekening
      AND status_fasilitas != 'TUTUP'
    INNER JOIN (
      SELECT
        nomor_registrasi,
        nama_depan,
        kode_pihak_terkait,
        TRUE is_individual
      FROM
        tblindividual
    UNION
      SELECT
        nomor_registrasi,
        nama_institusi,
        kode_pihak_terkait,
        FALSE is_individual
      FROM
        tblinstitusi) cif ON
      pinjaman.nomor_registrasi = cif.nomor_registrasi
      AND pinjaman.is_individual = cif.is_individual
    LEFT JOIN (
      SELECT
        tblsaldopinjaman.*
      FROM
        tblsaldopinjaman,
        (
        SELECT
          nomor_rekening,
          MAX(tgl_status) tgl_status
        FROM
          tblsaldopinjaman
        WHERE
          tgl_status <= @posisiData
        GROUP BY
          nomor_rekening) tanggalpinjaman
      WHERE
        tblsaldopinjaman.nomor_rekening = tanggalpinjaman.nomor_rekening
        AND tblsaldopinjaman.tgl_status = tanggalpinjaman.tgl_status) tblsaldopinjaman ON
      tblsaldopinjaman.nomor_rekening = fasilitas.nomor_rekening
    LEFT JOIN (
      SELECT
        nomor_rekening,
        SUM( ( percent_paripasu / 100 * nilai_taksasi_laporan ) ) offset_agunan
      FROM
        tblrekeningjaminan,
        tbltaksasijaminan
      WHERE
        tblrekeningjaminan.nomor_jaminan_id = tbltaksasijaminan.nomor_jaminan_id
      GROUP BY
        nomor_rekening) agunan ON
      agunan.nomor_rekening = fasilitas.nomor_rekening
    LEFT JOIN (
      SELECT
        a.nomor_rekening,
        b.nilai_biaya - a.total_amortisasi outstanding_provisi
      FROM
        (
        SELECT
          nomor_rekening,
          SUM(nilai_transaksi) total_amortisasi
        FROM
          tbltxacct
        WHERE
          no_rek_pembukuan IN ('13210', '13220', '13230')
            AND tgl_posting <= @posisiData
            AND posisi_db_cr_rekening = 'DB'
            AND nomor_rekening != no_rek_pembukuan
          GROUP BY
            nomor_rekening,
            posisi_db_cr_rekening) a
      LEFT JOIN (
        SELECT
          nomor_rekening,
          SUM(akum_bayar_biaya) nilai_biaya
        FROM
          tblbiayapinjaman
        WHERE
          jenis_biaya_pinjaman like '%PROVISI%'
          AND tgl_bayar_biaya <= @posisiData
        GROUP BY
          nomor_rekening) b ON
        a.nomor_rekening = b.nomor_rekening) provisi ON
      provisi.nomor_rekening = fasilitas.nomor_rekening
    LEFT JOIN (
      SELECT
        a.nomor_rekening,
        b.nilai_biaya - a.total_amortisasi outstanding_rest
      FROM
        (
        SELECT
          nomor_rekening,
          SUM(nilai_transaksi) total_amortisasi
        FROM
          tbltxacct
        WHERE
          no_rek_pembukuan IN ('13401')
            AND tgl_posting <= @posisiData
            AND posisi_db_cr_rekening = 'DB'
            AND nomor_rekening != no_rek_pembukuan
          GROUP BY
            nomor_rekening,
            posisi_db_cr_rekening) a
      LEFT JOIN (
        SELECT
          nomor_rekening,
          SUM(akum_bayar_biaya) nilai_biaya
        FROM
          tblbiayapinjaman
        WHERE
          jenis_biaya_pinjaman = 'BGRESTRUK'
          AND tgl_bayar_biaya <= @posisiData
        GROUP BY
          nomor_rekening) b ON
        a.nomor_rekening = b.nomor_rekening) rest ON
      rest.nomor_rekening = fasilitas.nomor_rekening
    LEFT JOIN (
      SELECT
        a.nomor_rekening,
        b.nilai_biaya - a.total_amortisasi outstanding_tlm
      FROM
        (
        SELECT
          nomor_rekening,
          SUM(nilai_transaksi) total_amortisasi
        FROM
          tbltxacct
        WHERE
          no_rek_pembukuan IN ('13310', '13320', '13330')
            AND tgl_posting <= @posisiData
            AND posisi_db_cr_rekening = 'CR'
            AND nomor_rekening != no_rek_pembukuan
          GROUP BY
            nomor_rekening,
            posisi_db_cr_rekening) a
      LEFT JOIN (
        SELECT
          nomor_rekening,
          SUM(akum_bayar_biaya) nilai_biaya
        FROM
          tblbiayapinjaman
        WHERE
          jenis_biaya_pinjaman = 'BIAYATLM'
          AND tgl_bayar_biaya <= @posisiData
        GROUP BY
          nomor_rekening) b ON
        a.nomor_rekening = b.nomor_rekening) tlm ON
      tlm.nomor_rekening = fasilitas.nomor_rekening
    LEFT JOIN (
      SELECT
        nomor_rekening,
        kode_kolektibilitas_effektif
      FROM
        (
        SELECT
          nomor_rekening norek,
          MAX(tgl_status_kolektibilitas) tglkolek
        FROM
          tblkolektibilitaspinjaman
        WHERE
          tgl_status_kolektibilitas <= @posisiData
        GROUP BY
          nomor_rekening) b
      INNER JOIN tblkolektibilitaspinjaman ON
        `tblkolektibilitaspinjaman`.`tgl_status_kolektibilitas` = b.tglkolek
        AND nomor_rekening = norek) tblkolektibilitaspinjaman ON
      fasilitas.nomor_rekening = tblkolektibilitaspinjaman.nomor_rekening)nomloan 