SELECT
tgl_posting,
SUM(saldo_akhir) saldo
FROM
tblsaldoacct
WHERE no_rek_pembukuan in(@coa)
AND kode_kantor = '999'
AND tgl_posting IN
(
  SELECT DATE_FORMAT(LAST_DAY (tgl_posting), '%Y%m%d')
  FROM
  tblsaldoacct
  WHERE no_rek_pembukuan in(@coa)
  AND kode_mata_uang = 'IDR'
  GROUP BY tgl_posting
)
AND tgl_posting >= CONCAT(DATE_FORMAT (NOW(), '%Y') - 1, '1231')
GROUP BY tgl_posting