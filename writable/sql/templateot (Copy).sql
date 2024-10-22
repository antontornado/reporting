SELECT
  a.`nomor_bilyet`,
  DATE_FORMAT(STR_TO_DATE(tgl_jatuh_tempo_bunga, '%Y%m%d'), '%d %b %Y') tgl_jatuh_tempo_bunga,
  no_rekening_penerima beneficiary_account_no,
  ROUND(nilai_bunga - nilai_pajak_bunga,0) transfer_amount,
  (SELECT bankid FROM mappingbank WHERE LEFT(bankid,3)=RIGHT(ot.sandi_bank,3) LIMIT 1) bank_id,
  CASE WHEN is_individual = 1 THEN '1' ELSE '2' END beneficiary_ID_type,
  '1' resident_type,
  nama_penerima beneficiary_customer_name_1,
  '' beneficiary_customer_name_2,
  CONCAT('PBY BDP ',a.nomor_bilyet) payment_detail_1,
  LEFT(
  CASE WHEN nama_joint_account IS NOT NULL THEN
	concat('A N ',nama_joint_account)
  ELSE
	CASE WHEN is_individual=0 THEN
		concat('A N ',nama_institusi)
	ELSE
		CASE WHEN tblindividual.nama_koresponden=''  OR tblindividual.nama_koresponden IS NULL THEN
			concat('A N ',nama_depan)
		ELSE
			concat('A N ',tblindividual.nama_koresponden)
		END
	END
  END,35) payment_detail_2,
  '' payment_detail_3,
  '' payment_detail_4,
  '' tax_code,
  '' tax_reference,
  CASE WHEN nilai_bunga - nilai_pajak_bunga <100000000 THEN '35'
  ELSE '20' END remittance_type
FROM
  tbljadwalbungadeposito a
  INNER JOIN
    (SELECT
      tblbilyetdeposito.record_status,
      nomor_rekening,
      kode_kantor,
      nomor_bilyet,
      kode_RO,
      kode_order_transfer_bunga,
      kode_CR_bunga_jatuh_tempo,
      no_rekening_penerima,
      sandi_bank,
      nama_penerima
    FROM
      tblbilyetdeposito
      LEFT JOIN tbltemplateordertransfer
        ON kode_order_transfer_bunga = kode_template) ot
    ON ot.nomor_bilyet = a.nomor_bilyet
    AND kode_RO = 'RO POKOK' AND kode_CR_bunga_jatuh_tempo='ORDER TRANSFER'  AND (tgl_jatuh_tempo_bunga BETWEEN @tgl1 AND @tgl2) AND ot.record_status='VALID' and kode_kantor in(@kantor)
  LEFT JOIN tbldeposito
    ON ot.nomor_rekening = tbldeposito.nomor_rekening
  LEFT JOIN tblindividual ON tbldeposito.`nomor_registrasi`=tblindividual.nomor_registrasi AND tbldeposito.`is_individual`=TRUE 
  LEFT JOIN tblinstitusi ON tbldeposito.nomor_registrasi=tblinstitusi.nomor_registrasi AND tbldeposito.`is_individual`=FALSE  
 ORDER BY tgl_jatuh_tempo_bunga