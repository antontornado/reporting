SELECT
  CASE WHEN nama_joint_account IS NOT NULL THEN
	CONCAT(nomor_bilyet,'-',nama_joint_account)
  ELSE
	CONCAT(nomor_bilyet,'-',nama_koresponden)
  END nomor_rekening
FROM
  tbldeposito,
  tblbilyetdeposito,
  (SELECT
    nomor_registrasi,
    CASE WHEN nama_koresponden='' THEN nama_depan ELSE nama_koresponden END nama_koresponden,
    1 is_individual
  FROM
    tblindividual
  UNION
  SELECT
    nomor_registrasi,
    CASE WHEN nama_koresponden='' THEN nama_institusi ELSE nama_koresponden END nama_koresponden,
    0 is_individual
  FROM
    tblinstitusi) nasabah
WHERE tbldeposito.nomor_rekening = tblbilyetdeposito.nomor_rekening
  AND tbldeposito.nomor_registrasi = nasabah.nomor_registrasi
  AND nasabah.is_individual = tbldeposito.is_individual
  AND tblbilyetdeposito.`record_status`='VALID'
  ORDER BY nama_koresponden