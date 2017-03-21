<?php
namespace Common\View\Helper;
use Zend\View\Helper\AbstractHelper;

/**
 * Renders stars for tariff ratings
 *
 * @author Robert Curth <robert.curth@check24.de>
 */
class StarsHelper extends AbstractHelper {
    var $rating;

    /**
     * Returns the helper when calling `$this->stars()` in view
     *
     * @return $this
     */
    public function __invoke(){
        return $this;
    }

    /**
     * Renders the stars
     *
     * @param $rating
     *
     * @return string
     */
    public function render($rating) {
        $stars_css_class = $this->star_css_class($rating);
        return $this->view->render('helper/stars.phtml', compact('stars_css_class'));
    }

    /**
     * Returns the css class for the rating
     *
     * @param float $rating
     *
     * @return string
     */
    public function star_css_class($rating) {

        $css_class = number_format($rating, 1);
        $css_class = str_replace(['.0', '.'], '', $css_class);
        return 'star' . $css_class;
    }
}