<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<Response>

    <Say voice="woman"><?php echo $data['ivr_say_zipcode']." ".$data['confirm']; ?></Say>

    <Gather action="<?php echo $data['redirect']; ?>" numDigits="1" method="GET" timeout="10">

        <Say voice="woman"><?php echo $data['iv_zipcode_confirm']; ?></Say>

    </Gather>

</Response>

