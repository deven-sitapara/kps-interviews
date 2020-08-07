<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       srs-kps-interviews
 * @since      1.0.0
 *
 * @package    Kps_Interviews
 * @subpackage Kps_Interviews/public/partials
 */


function form_shortcode($atts, $content = null)
{

    // $values = shortcode_atts(array(
    //     'url'       => '#',
    //     'target'    => '_self',
    // ), $atts);

    // return '<a href="' . esc_attr($values['url']) . '"  target="' . esc_attr($values['target']) . '" class="btn btn-green">' . $content . '</a>';
    ob_start();

?><form id="nds_add_candidate_meta_ajax_form" method="post" class="interview-form" action="#">
        <div id="nds_form_feedback"></div>
        <div id="postbox-container-2" class="postbox-container">
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                <div id="candidateinfo" class="postbox  rwmb-default">
                    <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Candidate Information</span><span class="toggle-indicator" aria-hidden="true"></span></button>
                    <h2 class="hndle ui-sortable-handle"><span>Candidate Information</span></h2>
                    <div class="inside">
                        <div class="rwmb-meta-box" data-autosave="false" data-object-type="post" data-object-id="101"><input type="hidden" id="nonce_candidateinfo" name="nonce_candidateinfo" value="25f360e17c"><input type="hidden" name="_wp_http_referer" value="/wp_test_interview_plugin/wordpress/wp-admin/post-new.php?post_type=interview">
                            <div class="rwmb-field rwmb-email-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_email">Email</label>

                                </div>
                                <div class="rwmb-input"><input placeholder="Email Address" type="email" size="30" id="kps-interviews_email" class="rwmb-email" name="kps-interviews_email"></div>
                            </div>
                            <div class="rwmb-field rwmb-text-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_first_name">First Name</label>

                                </div>
                                <div class="rwmb-input"><input size="30" placeholder="First Name" type="text" id="kps-interviews_first_name" class="rwmb-text" name="kps-interviews_first_name"></div>
                            </div>
                            <div class="rwmb-field rwmb-text-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_last_name">Last Name</label>

                                </div>
                                <div class="rwmb-input"><input size="30" placeholder="Last Name" type="text" id="kps-interviews_last_name" class="rwmb-text" name="kps-interviews_last_name"></div>
                            </div>
                            <div class="rwmb-field rwmb-checkbox_list-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_hobbies">Hobbies</label>

                                </div>
                                <div class="rwmb-input">
                                    <ul class="rwmb-input-list rwmb-collapse rwmb-inline" style="list-style: none;">
                                        <li><label><input value="tv" type="checkbox" size="30" class="rwmb-checkbox_list" name="kps-interviews_hobbies[]">TV</label></li>
                                        <li><label><input value="reading" type="checkbox" size="30" class="rwmb-checkbox_list" name="kps-interviews_hobbies[]">Reading</label></li>
                                        <li><label><input value="coding" type="checkbox" size="30" class="rwmb-checkbox_list" name="kps-interviews_hobbies[]">Coding</label></li>
                                        <li><label><input value="skiing" type="checkbox" size="30" class="rwmb-checkbox_list" name="kps-interviews_hobbies[]">Skiing</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rwmb-field rwmb-radio-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_gender">Gender</label>

                                </div>
                                <div class="rwmb-input">
                                    <ul class="rwmb-input-list rwmb-collapse rwmb-inline" style="list-style: none;">
                                        <li><label><input value="male" type="radio" size="30" class="rwmb-radio" name="kps-interviews_gender">Male</label></li>
                                        <li><label><input value="female" type="radio" size="30" class="rwmb-radio" name="kps-interviews_gender">Female</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rwmb-field rwmb-image-wrapper">
                                <div class="rwmb-label">
                                    <label for="kps-interviews_picture">Image Upload</label>

                                </div>
                                <div class="rwmb-input">
                                    <ul class="rwmb-uploaded ui-sortable" data-field_id="kps-interviews_picture" data-delete_nonce="d93809c9d6" data-reorder_nonce="05e60794b0" data-force_delete="0" data-max_file_uploads="1" data-mime_type="" style="display: none;"></ul>
                                    <div class="rwmb-file-new"><input id="kps-interviews_picture" class="rwmb-file-input" name="_file_kps-interviews_picture[]" accept="image/*" type="file"></div><input type="hidden" class="rwmb-file-index" name="_index_kps-interviews_picture" value="_file_kps-interviews_picture">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" class="interview-submit" value="Save Candidate">
    </form><?php

            $content = ob_get_contents();

            // Erase the buffer in case we want to use it for something else later
            ob_end_clean();

            return $content;
        }

        add_shortcode('kps_interview_form', 'form_shortcode');
