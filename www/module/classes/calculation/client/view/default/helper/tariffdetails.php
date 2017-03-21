<?php
$tariffdetails = new classes\calculation\client\controller\helper\generate_tariffdetails_pkv($this->tariff, $this->parameter);
$this->output($tariffdetails->get_output(),  false);
?>