<?php

namespace Drupal\social_auth_vipps\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\social_auth\Form\SocialAuthSettingsForm;

/**
 * Settings form for Social Auth Vipps.
 */
class VippsAuthSettingsForm extends SocialAuthSettingsForm {

  const SETTINGS = 'social_auth_vipps.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'social_auth_vipps_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array_merge(
      parent::getEditableConfigNames(),
      [self::SETTINGS]
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('social_auth_vipps.settings');

    $form['vipps_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Vipps Client settings'),
      '#open' => TRUE,
      '#description' => $this->t('You need to first create a Vipps App at <a href="@github-dev">@github-dev</a>',
        ['@github-dev' => 'https://portal.vipps.no']),
    ];

    $form['vipps_settings']['client_id'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Client ID'),
      '#default_value' => $config->get('client_id'),
      '#description' => $this->t('Copy the Client ID here.'),
    ];

    $form['vipps_settings']['client_secret'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Client Secret'),
      '#default_value' => $config->get('client_secret'),
      '#description' => $this->t('Copy the Client Secret here.'),
    ];

    $form['vipps_settings']['test_mode'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Test mode'),
      '#default_value' => $config->get('test_mode'),
      '#description' => $this->t('Send requests to the test server'),
    ];

    $form['vipps_settings']['show_in_login_form'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show in login form'),
      '#default_value' => $config->get('show_in_login_form'),
      '#description' => $this->t("Show button 'Login with Vipps' in the login form"),
    ];

    $form['vipps_settings']['authorized_redirect_url'] = [
      '#type' => 'textfield',
      '#disabled' => TRUE,
      '#title' => $this->t('Authorized redirect URIs'),
      '#description' => $this->t('Copy this value to <em>Authorized redirect URIs</em> field of your Vipps App settings.'),
      '#default_value' => Url::fromRoute('social_auth_vipps.callback')->setAbsolute()->toString(),
    ];

    $form['vipps_settings']['advanced'] = [
      '#type' => 'details',
      '#title' => $this->t('Advanced settings'),
      '#open' => FALSE,
    ];

    $form['vipps_settings']['advanced']['scopes'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Scopes for API call'),
      '#default_value' => $config->get('scopes'),
      '#description' => $this->t('Define any additional scopes to be requested, separated by a comma (e.g.: public_repo,user:follow).<br>
                                  The scopes \'user\' and \'user:email\' are added by default and always requested.<br>
                                  You can see the full list of valid scopes and their description <a href="@scopes">here</a>.', ['@scopes' => 'https://github.com/vippsas/vipps-login-api/blob/master/vipps-login-api.md#scopes']),
    ];

    $form['vipps_settings']['advanced']['endpoints'] = [
      '#type' => 'textarea',
      '#title' => $this->t('API calls to be made to collect data'),
      '#default_value' => $config->get('endpoints'),
      '#description' => $this->t('Define the Endpoints to be requested when user authenticates with Vipps for the first time<br>
                                  Enter each endpoint in different lines in the format <em>endpoint</em>|<em>name_of_endpoint</em>.<br>
                                  <b>For instance:</b><br>
                                  /user/repos|user_repos'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('social_auth_vipps.settings')
      ->set('client_id', $values['client_id'])
      ->set('client_secret', $values['client_secret'])
      ->set('test_mode', $values['test_mode'])
      ->set('show_in_login_form', $values['show_in_login_form'])
      ->set('scopes', $values['scopes'])
      ->set('endpoints', $values['endpoints'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
