<?php
$historycredittrigger= "DELIMITER $$

CREATE TRIGGER after_store_insert_credit_history
AFTER INSERT ON stores
FOR EACH ROW
BEGIN
  DECLARE credit_value_int INT;

  -- store_credits varchar olduğu için int'e dönüştürülüyor
  SET credit_value_int = CAST(NEW.store_credits AS SIGNED);

  INSERT INTO credit_history (
    store_id,
    process,
    credit_value,
    before_procces_credit_value,
    after_proccess_credit_value,
    credit_details,
    amount,
    created_at,
    updated_at
  ) VALUES (
    NEW.id,
    'loading',
    credit_value_int,
    0,
    credit_value_int,
    JSON_OBJECT('reason', 'Yeni mağaza eklendi', 'method', 'auto'),
    credit_value_int,
    NOW(),
    NOW()
  );
END$$

DELIMITER ;
"
?>