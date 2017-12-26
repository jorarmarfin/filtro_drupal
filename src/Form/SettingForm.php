<?php

/**
 * @file
 * Contains Drupal\SettingForm\Form\PopupForm
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
    return 'popup_settings';
  }

  /**
  * {@inheritdoc}
  */
  public function getEditableConfigNames() {
    return ['popup.settings','block.block.popup'];
  }

  /**
  * {@inheritdoc]
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('popup.settings')
      ->set('popup', $form_state->getValue('popup'))
      ->save();

    $this->config('block.block.popup')
      ->set('status', $form_state->getValue('popup'))
      ->save();


    parent::submitForm($form, $form_state);
  }
  /**
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('popup.settings');

    $form['popup'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Activar el Popup'),
      '#options' => [1 => 'Activar', 0 => 'Desactivar'],
      '#default_value' => $config->get('popup')
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