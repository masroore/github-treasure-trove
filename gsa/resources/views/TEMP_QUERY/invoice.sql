select 
  `i`.`id` AS `id`, 
  `i`.`kode` AS `kode`, 
  `i`.`id_customer` AS `id_customer`, 
  `i`.`tanggal_invoice` AS `tanggal_invoice`, 
  `i`.`mengetahui_oleh` AS `mengetahui_oleh`, 
  `i`.`status` AS `status`, 
  `i`.`keterangan` AS `keterangan`, 
  `i`.`total_koli` AS `total_koli`, 
  `i`.`total_harga` AS `total_harga`, 
  `i`.`created_at` AS `created_at`, 
  `i`.`created_by` AS `created_by`, 
  `i`.`deleted_at` AS `deleted_at`, 
  `i`.`updated_at` AS `updated_at`, 
  `i`.`updated_by` AS `updated_by`, 
  `i`.`total_kg` AS `total_kg`, 
  `i`.`total_doc` AS `total_doc`, 
  `i`.`total_oa` AS `total_oa`, 
  `i`.`metodepembayaran` AS `metodepembayaran`, 
  `u`.`nama` AS `mengetahui_oleh_user`, 
  `c`.`nama` AS `customer` 
from 
  (
    (
      `globalse_gsa`.`invoice` `i` 
      left join `globalse_gsa`.`users` `u` on(`u`.`id` = `i`.`mengetahui_oleh`)
    ) 
    left join `globalse_gsa`.`customer` `c` on(`c`.`id` = `i`.`id_customer`)
  ) 
where 
  `i`.`id` > 0
