<?php

//magaza kaydında kredi geçmişine mağza kredisini ekleme
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
";

// kampanya talebi olusturulduğunda ototmaik provizyona işlemin düşmesi
$kampanyaTalbeli = "DELIMITER //

CREATE TRIGGER after_campaign_insert
AFTER INSERT ON campaigns
FOR EACH ROW
BEGIN
  -- Sadece kampanya eklendiğinde kredi yüklemesi gerekiyorsa bu kontrol yapılabilir
  IF NEW.campaing_credit_amount > 0 THEN
    INSERT INTO credit_provision (
      amaount,
      store_id,
      proccess_statu,
      proccess,
     
      description,
      created_at,
      updated_at
    ) VALUES (
      NEW.campaing_credit_amount,
      NEW.store_id,
      'waiting',
      'spending_credit',
      JSON_OBJECT(
        'from_campaign_id', NEW.id,
        'title', NEW.campaign_title,
          'proccess', 'Kampanya Talebi'
      ),
      NOW(),
      NOW()
    );
  END IF;
END//

DELIMITER ;
";

$provisiongüncellemesonrasikredigecmisigüncelleme  = `DELIMITER //

CREATE TRIGGER trg_after_provision_processed
AFTER UPDATE ON credit_provision
FOR EACH ROW
BEGIN
  -- Değişken tanımları
  DECLARE credit_val INT;
  DECLARE previous_credit INT;
  DECLARE new_credit INT;
  DECLARE credit_details_json TEXT;

  -- Sadece 'waiting' → 'processed' geçişi olduğunda çalış
  IF OLD.proccess_statu != 'processed' AND NEW.proccess_statu = 'processed' THEN

    SET credit_val = NEW.amaount;

    -- Mevcut toplam kredi (önceki bakiye)
    SELECT IFNULL(
      (SELECT credit_value FROM credit_history 
       WHERE store_id = NEW.store_id 
       ORDER BY id DESC LIMIT 1),
      0
    )
    INTO previous_credit;

    -- Yeni kredi (yani işlem sonrası kalan bakiye)
    SET new_credit = 
      CASE 
        WHEN NEW.proccess = 'upload_credit' THEN previous_credit + credit_val
        ELSE previous_credit - credit_val
      END;

    -- JSON içeriği sabit
    SET credit_details_json = '{"reason": "Kampanya Onaylandı", "method": "auto"}';

    -- credit_history tablosuna kayıt
    INSERT INTO credit_history (
      store_id,
      process,
      credit_value,  -- ✅ artık bu işlem sonrası kalan bakiye
      before_procces_credit_value,
      after_proccess_credit_value,
      credit_details,
      amount,        -- ✅ bu işlem tutarı
      created_at,
      updated_at
    )
    VALUES (
      NEW.store_id,
      CASE 
        WHEN NEW.proccess = 'upload_credit' THEN 'loading'
        ELSE 'spending'
      END,
      new_credit,             -- ✅ kalan bakiye
      previous_credit,
      new_credit,
      credit_details_json,
      credit_val,             -- ✅ işlem tutarı
      NOW(),
      NOW()
    );

  END IF;
END //

DELIMITER ;


`;
?>