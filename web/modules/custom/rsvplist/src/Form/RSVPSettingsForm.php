<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;

/**
 * Class RSVPSettingsForm.
 *
 * @package Drupal\rsvplist\Form
 */
class RSVPSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'rsvplist.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rsvplist_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $types = NodeType::loadMultiple();
    $select_types = array();
    foreach ($types as $key => $value) {
      $select_types[$key] = $value->label();
    }
    $config = $this->config('rsvplist.settings');
    $form['rsvplist_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('The content types to enable RSVP collection for'),
      '#description' => $this->t('On the specified node types, an RSVP option will be available and can be enabled while that node is being editied.'),
      '#options' => $select_types,
      '#default_value' => $config->get('allowed_types'),
    ];
    $form['array_filter'] = ['#type' => 'value', '#value' => true];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $allowed_types = array_filter($form_state->getValue('rsvplist_types'));
    sort($allowed_types);
    $this->config('rsvplist.settings')
      ->set('allowed_types', $allowed_types)
      ->save();
    parent::submitForm($form, $form_state);
  }
}
