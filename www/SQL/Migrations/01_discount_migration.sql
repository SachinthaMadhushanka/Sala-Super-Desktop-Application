-- Step 1: Add the new column 'ourprice' to the table
ALTER TABLE product_stock
  ADD ourprice FLOAT;

-- Step 2: Update the new column 'ourprice' with values from 'saleprice'
UPDATE product_stock
SET ourprice = saleprice;
