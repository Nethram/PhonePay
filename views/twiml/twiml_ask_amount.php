<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<Response>
	<Gather action="<?php echo $data['redirect']; ?>" finishOnKey="*" method="GET" timeout="10">

    <Say voice="woman"><?php echo $data['ivr_ask_amount'] ?></Say>

    </Gather>

</Response>

