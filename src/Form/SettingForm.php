<?php

/**
 * @file
 * Contains Drupal\SettingForm\Form\TestFormForm
 */

namespace Drupal\popup\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implement a settings form
 */
class SettingForm extends ConfigFormBase {

  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'Form_settings';
  }

  /**
  * {@inheritdoc}
  */
  public function getEditableConfigNames() {
    return ['SettingForm.settings'];
  }

  /**
  * {@inheritdoc]
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('SettingForm.settings')
      ->set('test', $form_state->getValue('test'))
      ->save();
    parent::submitForm($form, $form_state);
  }
  /**
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('SettingForm.settings');
    $form['test'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('This is the test var'),
      '#default_value' => $config->get('test')
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array (
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return parent::buildForm($form, $form_state);
  }
}