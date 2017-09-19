<?php
/**
 * @file
 * Contains \Drupal\custom_form\Form\MyCustomForm.
 */

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * My Custom form.
 */
class MyCustomForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = array(
      '#type' => 'textfield',
      '#size' => 15,
      '#placeholder' => t('Name'),
    );

    $form['description'] = array(
      '#type' => 'textarea',
      '#required' => TRUE,
      '#placeholder' => t('Description'),
    );

    $form['email'] = array(
      '#type' => 'email',
      '#required' => TRUE,
      '#placeholder' => t('E-mail address'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('name') == '' ) {
      $form_state->setErrorByName('name', t('This is a required field.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $name = $form_state->getValue('name');
    $description = $form_state->getValue('description');
    $email = $form_state->getValue('email');

    

    $content = \Drupal::database()->insert('custom_form_table');
    $content->fields(['name', 'details', 'email']);
    $content->values([$name, $description, $email]);
    $content->execute();


    $message = t('Your information has been successfully submitted.') ;
    drupal_set_message($message);
  }
}