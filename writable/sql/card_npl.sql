SELECT SUM(saldo_pinjaman_pokok)npl FROM(
                SELECT
                  pinjaman.nomor_rekening,
                  saldo_pinjaman_pokok,
                  kode_kolektibilitas_effektif
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
                  fasilitas.nomor_rekening = tblkolektibilitaspinjaman.nomor_rekening) ss
                WHERE ss.kode_kolektibilitas_effektif>2