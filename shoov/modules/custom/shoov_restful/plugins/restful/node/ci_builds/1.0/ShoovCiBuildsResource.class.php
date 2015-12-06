<?php

/**
 * @file
 * Contains ShoovCiBuildsResource.
 */

class ShoovCiBuildsResource extends \ShoovEntityBaseNode {


  /**
   * Overrides \RestfulEntityBaseNode::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['enabled'] = array(
      'property' => 'field_ci_build_enabled',
    );

    $public_fields['git_branch'] = array(
      'property' => 'field_git_branch',
    );

    $public_fields['repository'] = array(
      'property' => 'og_repo',
      'resource' => array(
        'repository' => array(
          'name' => 'repositories',
          'full_view' => FALSE,
        ),
      ),
    );

    $public_fields['interval'] = array(
      'property' => 'field_ci_build_interval',
    );

    $public_fields['can_be_changed'] = array(
      'property' => 'nid',
      'callback' => array($this, 'checkUpdatePermissions'),
    );

    $public_fields['private_key'] = array(
      'property' => 'field_private_key',
    );

    return $public_fields;
  }

  /**
   * Callback. Check user has permissions to edit node.
   *
   * @param array $value
   *   The image array.
   *
   * @return bool
   *   Returns TRUE if user can edit node.
   */
  protected function checkUpdatePermissions($value) {
    $account = $this->getAccount();
    return node_access('update', $value, $account);
  }

  /**
   * {@inheritdoc}
   *
   * Catch '.shoov.yml is missing' exception and through
   * restful exception instead.
   */
  public function createEntity() {
    try {
      parent::createEntity();
    }
    catch (Exception $e) {
      if ($e->getMessage() == '.shoov.yml is missing in the root of the repository.') {
        throw new \RestfulBadRequestException(".shoov.yml is missing in the root of the repository.");
      }
      throw $e;
    }
  }

  /**
   * {@inheritdoc}
   *
   * Catch '.shoov.yml is missing' exception and through
   * restful exception instead.
   */
  public function patchEntity($entity_id) {
    try {
      parent::patchEntity($entity_id);
    }
    catch (Exception $e) {
      if ($e->getMessage() == '.shoov.yml is missing in the root of the repository.') {
        throw new \RestfulBadRequestException(".shoov.yml is missing in the root of the repository.");
      }
      throw $e;
    }
  }
}
