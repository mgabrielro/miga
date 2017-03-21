<div class="favorite-page">

    <?php if ($this->deviceoutput != 'app') : ?>
        <div id="favorite-backlink-container">
            <a id="favorite-backlink" href="<?php echo $this->backlink_url; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> zurück</a>
        </div>
    <?php endif; ?>

    <?php if ($this->has_favorites && $this->favorites_groups) : ?>

        <div class="headline">
            Mein Merkzettel für private Krankenversicherung (<span id="favorite-total-counter"><?php echo $this->count_favorites ?></span>)
        </div>

        <div id="result">

            <?php foreach($this->favorites_groups AS $profesion_group => $data) : ?>

                <?php foreach($data AS $birthdate) : ?>

                    <?php $count_tariffs = count($birthdate['tariffs']); ?>
                    <?php $age_text      = ($birthdate['age'] == 1) ? ' 1 Jahr' : $birthdate['age'] . ' Jahre'; ?>
                    <?php $group_name    = $profesion_group . ', ' .$age_text ?>

                    <div class="favorite-group-records" data-group-name="<?php echo $group_name; ?>">

                        <div class="favorite-group-headline">
                            <?php echo $group_name ?>
                        </div>

                        <div class="favorite-group-count-object">
                            <?php echo ($count_tariffs == 1) ? '1 gemerkter Tariff' : $count_tariffs . ' gemerkte Tarife'; ?>
                        </div>

                        <?php foreach($birthdate['tariffs'] AS $tariffversion_id => $data) : ?>

                            <?php

                                /** @var \classes\calculation\mclient\model\tariff\pkv $tariff */
                                $this->tariff      = new \classes\calculation\mclient\model\tariff\pkv($data['tariff']);
                                $this->parameter   = new \classes\calculation\client\model\parameter\pkv($data['parameter']);
                                $this->favorite_id = (isset($data['favorite']['id'])) ? (int) $data['favorite']['id'] : 0;

                                $this->tariff_detail_link = $this->url('mobile/pkv/tariffdetail', [], ['query' => [
                                    'c24api_tariffversion_id'            => $this->tariff->get_tariff_version_id(),
                                    'c24api_calculationparameter_id'     => $this->parameter->get_id(),
                                    'c24api_tariffversion_variation_key' => 'base',
                                    'c24_controller'                     => \classes\calculation\mclient\controller\pkv\tariff_detail::DEFAULT_CONTROLLER,

                                    /**
                                     * ATTENTION: This two values are setted in the API from the favorite record NOT from the received tariff,
                                     * because in this case (favorite page), we need the infos from the moment when the user has added the tariff
                                     * as favorite and not what we receive NOW from M&M
                                     */
                                    'c24_promotion_type'                 => $this->tariff->get_promotion_type(),
                                    'c24_is_gold_grade'                  => $this->tariff->is_gold_grade()
                                ]]);

                            ?>

                            <div class="favorite-softdelete-wrapper off" data-group-identifier="<?php echo $group_name; ?>" data-favorite-id="<?php echo $this->favorite_id; ?>">
                                <div class="favorite-softdelete-header">
                                    <span class="favorite-provider-name"><?php echo $this->tariff->get_provider_name(); ?></span>
                                    <span class="favorite-tariff-name">- <?php echo $this->tariff->get_tariff_name(); ?></span>
                                </div>
                                <div class="favorite-softdelete-bottom">
                                    <span class="favorite-notice">vom Merkzettel gelöscht</span>
                                    <span class="favorite-reactivate-link" data-tariffversion-id="<?php echo $this->tariff->get_tariff_version_id(); ?>">rückgängig</span>
                                </div>
                            </div>

                            <?php require __DIR__ . '/result_row.php'; ?>

                        <?php endforeach; ?>

                    </div>

                <?php endforeach; ?>

            <?php endforeach; ?>

        </div>
        
    <?php else: ?>

        <div id="no-favorites-message">
            <h3>Mein Merkzettel für private Krankenversicherung</h3>
            <div id="no-favorites-message-box">
                <h4>Ihr Merkzettel ist noch leer</h4>
                <p>Fügen Sie über das <i class="fa fa-heart-o"></i>-Symbol Ihre Favoriten zum Merkzettel hinzu.</p>
                <ul>
                    <li>Speichern Sie Ihre Favoriten für spätere Vergleiche</li>
                    <li>Rufen Sie Ihren Merkzettel auf dem PC oder Handy ab</li>
                </ul>
            </div>
        </div>

    <?php endif; ?>

</div>