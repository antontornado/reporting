SELECT
  tgl_valuta,
  tblrekeningkoran.nomor_rekening,
  tblrekeningkoran.kode_jenis_aplikasi produk,
  CONCAT(kode_kejadian_default,'-',keterangan_menu_default)menu,
  posisi_db_cr_rekening posisi,
  keterangan_transaksi,
  nilai_transaksi
FROM
  tblrekeningkoran,
  (SELECT
    nomor_rekening,
    'PINJAMAN' kode_jenis_aplikasi
  FROM
    tblpinjaman
  WHERE nomor_registrasi = @noReg
    AND is_individual = @jenisNasabah
  UNION
  SELECT
    nomor_rekening,
    'TABUNGAN' kode_jenis_aplikasi
  FROM
    tbltabungan
  WHERE nomor_registrasi = @noReg
    AND is_individual = @jenisNasabah
  UNION
  SELECT
    nomor_rekening,
    'DEPOSITO' kode_jenis_aplikasi
  FROM
    tbldeposito
  WHERE nomor_registrasi = @noReg
    AND is_individual = @jenisNasabah) tblRekNasabah,
   tblmenudetail
WHERE tblrekeningkoran.nomor_rekening = tblRekNasabah.nomor_rekening
  AND tblrekeningkoran.kode_jenis_aplikasi = tblRekNasabah.kode_jenis_aplikasi
  AND tblmenudetail.kode_menu_default=kode_kejadian_default
  AND kode_kejadian_default NOT IN ('09000','04003','04000','99401','05632','05633','05876','05626','05120','09001','05235','05693')  
  AND nilai_transaksi !=0
  AND tgl_posting BETWEEN @posisiData1
  AND @posisiData2
ORDER BY tblrekeningkoran.kode_jenis_aplikasi,record_number