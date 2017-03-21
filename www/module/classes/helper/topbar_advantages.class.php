<?php

namespace classes\helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class topbar_advantages
 *
 * @author Jaha Deliu <jaha.deliu@check24.de>
 */
class topbar_advantages extends AbstractHelper
{
    /**
     * PointPlan Helper
     *
     * @var \Application\View\Helper\PointPlan
     */
    protected $point_plan_helper;

    /**
     * CS_Code
     *
     * @var  null|\shared\classes\cscode\client\helper\dataobject\cscode
     */
    protected $cs_code;

    /**
     * Advantages DIV label
     *
     * @var string
     */
    protected $advantages_div_label = '';

    /**
     * Advantages DIV value
     *
     * @var string
     */
    protected $advantages_div_value = '';

    /**
     * Advantages DIV classname
     *
     * @var string
     */
    protected $advantages_div_label_classname = '';

    /**
     * Advantages DIV label when no advantages active
     *
     * @var string
     */
    protected $advantages_div_label_not_active = '';

    /**
     * Advantages DIV label when no advantages active
     *
     * @var string
     */
    protected $advantages_div_value_not_active = '';

    /**
     * Advantages DIV cs text value
     *
     * @var string
     */
    protected $advantages_div_cs_value = '';

    /**
     * Advantages active?
     *
     * @var bool
     */
    protected $advantages_active = false;

    /**
     * Insure sum
     *
     * @var integer
     */
    protected $insure_sum;

    /**
     * Invokes current method
     *
     * @param \shared\classes\cscode\client\helper\dataobject\cscode|null $cs_code CS_CODE
     * @param integer $insure_sum
     *
     * @return mixed
     */
    public function __invoke($cs_code, $insure_sum) {

        $this->point_plan_helper = $this->getView()->getHelperPluginManager()->get('pointplan');
        $this->cs_code = $cs_code;
        $this->insure_sum = $insure_sum;
        $this->special_action_ribbon = $this->getView()->getHelperPluginManager()->get('special_action_ribbon');
        $this->check_cscode();
        $this->check_c24points();
        $this->check_special_action_ribbon();
        $this->set_advantages();

        return $this;

    }

    /**
     * Check CS Code
     * Checks if we have a cs_code and generates/sets it's output text
     *
     * @return void
     */
    protected function check_cscode() {

        if (
            ($this->cs_code instanceof \shared\classes\cscode\client\helper\dataobject\cscode) &&
            $this->cs_code->get_Value() > 0
        ) {
            $this->add_text('advantages_div_cs_value', $this->cs_code->get_Value() . '€ Gutschein (vorgemerkt)');
            $this->advantages_active = true;
        }

    }

    /**
     * Checks for c24Points and adds image to div-value
     *
     * @return void
     */
    protected function check_c24points() {

        if ($this->point_plan_helper->isActive()) {
            $this->add_text('advantages_div_value', $this->point_plan_helper->render('small'));
            $this->advantages_active = true;
        }

    }

    /**
     * Checks for c24Points and renders image to div-value
     *
     * @return void
     */
    protected function check_special_action_ribbon() {

        if ($this->special_action_ribbon->is_active()) {
            $this->add_text('advantages_div_value', $this->special_action_ribbon->render_ribbon());
            $this->advantages_active = true;
        }
    }

    /**
     * Checks for active advantages and sets the correct values to parameters
     *
     * @return void
     */
    protected function set_advantages() {

        if ($this->advantages_active) {

            $this->advantages_div_label = 'CHECK24 Vorteile:';
            $this->advantages_div_label_not_active = 'Versicherungssumme:';
            $this->advantages_div_value_not_active = $this->insure_sum;
            $this->advantages_div_label_classname = 'advantages-text';

        } else {

            $this->advantages_div_label = 'Versicherungssumme:';
            $this->advantages_div_label_classname = 'feature-description-text';
            $this->advantages_div_value = $this->insure_sum;
            $this->advantages_div_label_not_active = '';
            $this->advantages_div_value_not_active = '';

        }

    }

    /**
     * Adds Text/HTML to given parameter;
     *
     * @param string $name Parameter Name
     * @param string $value Parameter Value
     *
     * @return void
     */
    protected function add_text($name, $value) {
        $this->{$name} .= $value;
    }

    /**
     * Get the value of parameter
     *
     * @param $param
     *
     * @return mixed
     */
    public function __get($name) {

        if (isset($this->{$name})) {
            return $this->{$name};
        }

        return '';
    }
}