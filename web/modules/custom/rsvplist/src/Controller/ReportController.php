<?php

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
 * Class ReportController.
 *
 * @package Drupal\rsvplist\Controller
 */
class ReportController extends ControllerBase {

  /**
   * Get a list of all the RSVPs
   *
   * @return []
   */
  public function load() {
    $select = Database::getConnection()->select('rsvplist', 'r');
    $select->join('users_field_data', 'u', 'r.uid = u.uid');
    $select->join('node_field_data', 'n', 'r.nid = n.nid');
    $select->addField('u', 'name', 'username');
    $select->addField('n', 'title');
    $select->addField('r', 'mail');
    $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
    return $entries;
  }

  /**
   * Report.
   *
   * @return string
   */
  public function report() {
    $content = [];
    $content['message'] = [
      '#markup' => $this->t('Below is a list of all Event RSVPs including username, email address and the name of the event they will be attending.')
    ];
    $headers = [
      t('Name'),
      t('Event'),
      t('Email')
    ];
    $rows = [];
    foreach ($entries = $this->load() as $entry) {
      $rows[] = array_map('\Drupal\Component\Utility\SafeMarkup::CheckPlain', $entry);
    }
    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => t('No entries available.')
    ];
    $content['#cache']['max-age'] = 0;
    return $content;
  }
}
