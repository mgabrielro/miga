<div id="c24OverlayLayerLoginForm">

    <div class="c24-content">

        <div class="c24-login">

            <a class="c24-close" onclick="$.rs.user.loginHide();"><!-- --></a>

            <span class="c24-login-headline">Einloggen bei <img src="/images/form/stuff/logo-c24.gif" alt="CHECK24" title="CHECK24" style="vertical-align: middle;" /></span>

            <div class="c24-login-error"></div>

            <table width="100%">

                <tr>

                    <td class="left">
                        <label for="c24LoginEmail">E-Mail</label><br />
                        <span class="c24-form-error" id="c24LoginEmailError"></span>
                    </td>

                    <td class="right">
                        <input type="text" id="c24LoginEmail" value="" name="c24LoginEmail" onkeyup="if ((event.which || window.event.keyCode) == 13) $('#c24LoginSubmit').trigger('click');" class="c24-form-text" />
                        <div style="display: none;" class="c24RegisterErrorBoxInfo" id="c24LoginEmailError"></div>
                    </td>

                </tr>

                <tr>

                    <td class="left">
                        <label for="c24LoginPassword">Passwort</label><br />
                        <span class="c24-form-error" id="c24LoginPasswordError"></span>
                    </td>

                    <td class="right">
                        <input type="password" id="c24LoginPassword" value="" name="c24LoginPassword" onkeyup="if ((event.which || window.event.keyCode) == 13) $('#c24LoginSubmit').trigger('click');"  class="c24-form-text" />
                    </td>

                </tr>

                <tr>

                    <td class="left"><!-- --></td>

                    <td class="right">
                        <a href="javascript: void(0)" onclick="$.rs.user.loginreminderShow();">Passwort vergessen?</a>
                    </td>

                </tr>

                <tr class="last">

                    <td class="left"><!-- --></td>

                    <td class="right" style="text-align: right;">

                        <div class="c24-clearfix">
                            <input type="button" class="c24-button" onclick="$.rs.user.login($('#c24LoginEmail').val(), $('#c24LoginPassword').val());" id="c24LoginSubmit" value="einloggen">
                            <div class="c24-waiting-loader" id="c24-login-login-waiting"><!-- --></div>
                        </div>

                    </td>

                </tr>

            </table>

        </div>

     </div>

</div>

<div id="c24OverlayLayerLoginreminderForm">

    <div class="c24-content">

        <div class="c24-login">

            <a class="c24-close" onclick="$.rs.user.loginHide();"><!-- --></a>

            <span class="c24-login-headline">Passworthilfe</span>

            <div class="c24-login-error"></div>

            <table width="100%">

                <tr>

                    <td class="left">
                        <label for="c24LoginreminderEmail">E-Mail</label><br />
                        <span class="c24-form-error" id="c24LoginreminderEmailError"></span>
                    </td>

                    <td class="right">
                        <input type="text" onkeyup="if ((event.which || window.event.keyCode) == 13) $('#c24LoginreminderSubmit').trigger('click');" class="c24-form-text" value="" id="c24LoginreminderEmail" name="c24LoginreminderEmail">
                    </td>

                </tr>

                <tr>

                    <td class="left">
                        <label for="c24LoginreminderBirthdate">Geburtsdatum</label><br />
                        <span class="c24-form-error" id="c24LoginreminderBirthdateError"></span>
                    </td>

                    <td class="right">
                        <input type="text" onkeyup="if ((event.which || window.event.keyCode) == 13) $('#c24LoginreminderSubmit').trigger('click');" class="c24-form-text hasDatepicker" value="" id="c24LoginreminderBirthdate" name="c24LoginreminderBirthdate">
                    </td>

                </tr>

                <tr class="last">

                    <td class="left" style="text-align: left;">
                        <input type="button" class="c24-button" onclick="$.rs.user.loginShow();" value="« zurück">
                    </td>

                    <td class="right" style="text-align: right;">

                        <div class="c24-clearfix">
                            <input type="button" class="c24-button" onclick="$.rs.user.loginreminder($('#c24LoginreminderEmail').val(), $('#c24LoginreminderBirthdate').val());" value="weiter">
                            <div class="c24-waiting-loader" id="c24-login-reminder-waiting"><!-- --></div>
                        </div>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

<div id="c24OverlayLayerLoginremindercompleteForm">

    <div class="c24-content">

        <div class="c24-login">

            <a class="c24-close" onclick="$.rs.user.loginHide();"><!-- --></a>

            <span class="c24-login-headline">Passworthilfe</span>

            <div class="c24-login-error"></div>

            <div class="c24-login-text">
                Gehört die eingegebene E-Mail-Adresse <span id="c24LoginreminderLabelEmail"></span>&nbsp; bereits zu einem uns<br />
                vorliegenden Kundenkonto, erhalten Sie von uns eine E-Mail, in der wir Ihnen erläutern, wie Sie Ihr<br />
                Passwort neu anlegen können.<br /><br />
                Wenn Sie diese E-Mail nicht erhalten, sehen Sie bitte in Ihrem Spam-Ordner nach.
            </div>

            <table width="100%">

                <tr>

                    <td class="left" style="text-align: left;">
                        <input type="button" class="c24-button" onclick="$.rs.user.loginreminderShow();" value="« zurück">
                    </td>

                    <td class="right" style="text-align: right;">
                        <input type="button" class="c24-button" onclick="$.rs.user.loginShow();" value="einloggen">
                    </td>

                </tr>

            </table>

        </div>

     </div>

</div>

<div id="c24OverlayLayerBlocked">

    <div class="c24-content">

        <div class="c24-login">

            <a class="c24-close" onclick="$.rs.user.loginHide();"><!-- --></a>

            <div class="c24-login-text">
                Sehr geehrter Kunde,<br />
                aufgrund mehrfacher Falscheingaben wurde Ihr Konto aus Sicherheitsgründen für 1 Stunde gesperrt.
            </div>

            <table width="100%">

                <tr class="last">

                    <td class="left" style="text-align: left;">
                        <input type="button" class="c24-button" onclick="$.rs.overlay.getInstance().hide();" value="Schließen">
                    </td>

                    <td class="right" style="text-align: right;"><!-- --></td>

                </tr>

            </table>

        </div>

    </div>

</div>

<script type="text/javascript">
    /* <![CDATA[ */
    $.rs.controller.addScriptUrl('json_c24login_login', '<?php $this->output($this->ajax_c24login_login_link, false); ?>');
    $.rs.controller.addScriptUrl('json_c24login_logout', '<?php $this->output($this->ajax_c24login_logout_link, false); ?>');
    $.rs.controller.addScriptUrl('json_c24login_loginreminder', '<?php $this->output($this->ajax_c24login_loginreminder_link, false); ?>');
    /* ]]> */
</script>