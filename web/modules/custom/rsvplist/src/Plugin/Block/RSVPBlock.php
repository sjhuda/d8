<?php

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'RSVPBlock' block.
 *
 * @Block(
 *  id = "rsvp_block",
 *  admin_label = @Translation("RSVP Block"),
 * )
 */
class RSVPBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['rsvpblock']['#markup'] = 'Implement RSVPBlock.';

    return $build;
  }

}
