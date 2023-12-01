ALTER TABLE invoice_details
  ADD ourprice FLOAT;


UPDATE invoice_details
SET ourprice = unit_price;
