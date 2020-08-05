<?php
/* 
Plugin Name: Import CSV Files 
Plugin URI: http://www.w3examples.com/wordpress/working_import_csv_files.php
Description: Import Posts or Pages from CSV Files 
Author: George Iron
Version: 1.0 
Author URI: http://www.w3examples.com
*/


class GIW3ImportCSVFiles
{

	const ODELIMITER = "giw3csvfi_delimiter";
	const ONUMBERFIELDS = "giw3csvfi_nfields";
	const OTYPE = "giw3csvfi_instype";
	private $step1 = FALSE;
	private $step2 = FALSE;
	private $step3 = FALSE;
	private $error = '';
	private $filename = '';
	private $delimiter = ',';
	private $column_count = 0;
	private $mapped = array();
	private $insertype = '';
	private $plugin_prefix = "kps-interviews_";

	function GetValuesFromArray(&$arrSource, &$arrDest)
	{
		if (!isset($arrSource['post_status'])) {
			$post_status = '';
			$this->GetPost('post_status_user', $post_status);
			$arrDest['post_status'] = $post_status;
		} else {
			$fromfile =  $arrSource['post_status'];
			strtolower($fromfile);
			trim($fromfile);
			if ($fromfile != 'publish' || $fromfile != 'draft' || $fromfile != 'pending' || $fromfile != 'private') {
				$post_status = '';
				$this->GetPost('post_status_user', $post_status);
				$arrDest['post_status'] = $post_status;
			} else
				$arrDest['post_status'] = $fromfile;
		}
		if (isset($arrSource['post_tags'])) {
			$arrDest['tags_input'] = $arrSource['post_tags'];
		}



		/**
		 * All custom fields to import : Picture cant not be imported
		 */
		$custom_fields = ["first_name", "last_name", "email", "hobbies", "gender"];
		$meta_input = [];
		foreach ($custom_fields as $custom_field) {

			if (isset($arrSource[$custom_field])) {

				if ($custom_field === 'hobbies') {
					$meta_input[$this->plugin_prefix . $custom_field] = explode(",", $arrSource[$custom_field]);
				} else {
					$meta_input[$this->plugin_prefix . $custom_field] = wp_strip_all_tags($arrSource[$custom_field]);
				}
			}
		}
		$arrDest['meta_input'] = $meta_input;

		//$arrDest['post_title'] = wp_strip_all_tags($arrSource['post_title']);
		//$arrDest['post_content'] = convert_chars($arrSource['post_content']);

		$arrDest['post_type'] = $this->insertype;
		// if (isset($arrSource['post_excerpt'])) {
		// 	$arrDest['post_excerpt'] = $arrSource['post_excerpt'];
		// }
		// if (isset($arrSource['post_slug'])) {
		// 	$arrDest['post_name'] = $arrSource['post_slug'];
		// }

		if (isset($arrSource['post_date'])) {
			$timestamp = strtotime($arrSource['post_date']);
			if ($timestamp !==  false) {
				$arrDest['post_date'] = date('Y-m-d H:i:s', $timestamp);
			}
		}
		// echo "<pre>";
		// print_r($arrSource);

		// print_r($arrDest);
		// exit;
	}

	function create_or_get_categories(&$arrSource, &$arrDest)
	{
		if ($this->insertype == 'page') {
			return;
		}
		$ids = array();
		$cats = '';
		if (!isset($arrSource['post_category'])) {
			if (!$this->GetPost('import_csvfile_cat', $cats))
				return;
			if ($cats != '0') {
				$ids[] = $cats;
				$arrDest['post_category'] = $ids;
				return;
			}
		} else {
			$cats = $arrSource['post_category'];
		}
		if ($cats == '0' || $cats == '' || $cats == 'NULL') {
			return;
		}
		$items = array_map('trim', explode(',', $cats));
		foreach ($items as $item) {
			if (is_numeric($item)) {
				if (get_category($item) !== null) {
					$ids[] = $item;
				}
			} else {
				// item can be a single category name or a string such as
				// Parent > Child > Grandchild
				$parent_id = 0;
				$categories = array_map('trim', explode('>', $item));
				if (count($categories) > 1 && is_numeric($categories[0])) {
					$parent_id = $categories[0];
					if (get_category($parent_id) !== null) {
						// valid id, everything's ok
						$categories = array_slice($categories, 1);
					}
					continue;
				}

				$term_id = 0;
				foreach ($categories as $category) {
					if ($category) {
						if ($parent_id == 0) {
							$term = $this->term_exists($category, 'category');
							if ($term) {
								$term_id = $term['term_id'];
							} else {
								$term_id = wp_insert_category(array(
									'cat_name' => $category
								));
							}
						} else {
							$term = $this->term_exists($category, 'category', $parent_id);
							if ($term) {
								$term_id = $term['term_id'];
							} else {
								$term_id = wp_insert_category(array(
									'cat_name' => $category,
									'category_parent' => $parent_id,
								));
							}
						}

						$parent_id = $term_id;
					}
				}
				$ids[] = $term_id;
			}
		}
		$arrDest['post_category'] = $ids;
	}

	function term_exists($term, $taxonomy = '', $parent = 0)
	{
		if (function_exists('term_exists')) { // 3.0 or later
			return term_exists($term, $taxonomy, $parent);
		} else {
			return is_term($term, $taxonomy, $parent);
		}
	}

	function fopen_utf8($filename)
	{
		if (!file_exists($filename) || !is_readable($filename))
			return 0;
		$encoding = '';
		$handle = fopen($filename, 'r');
		$bom = fread($handle, 2);
		rewind($handle);

		if ($bom === chr(0xff) . chr(0xfe)  || $bom === chr(0xfe) . chr(0xff)) {
			// UTF16 Byte Order Mark present
			$encoding = 'UTF-16';
		}
		//        $encoding = mb_detect_encoding($file_sample , 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
		$bytes = fread($handle, 3);
		if ($bytes != pack('CCC', 0xef, 0xbb, 0xbf)) {
			rewind($handle);
		}
		if ($encoding != '') {
			stream_filter_append($handle, 'convert.iconv.' . $encoding . '/UTF-8');
		}
		return ($handle);
	}

	function checkIsPost($postvar, $postval)
	{
		if (!isset($_POST[$postvar]))
			return FALSE;
		if (!$_POST[$postvar] == $postval)
			return FALSE;
		return TRUE;
	}

	function GetPost($postvar, &$postval)
	{
		if (!isset($_POST[$postvar]))
			return FALSE;
		$postval = $_POST[$postvar];
		if ($postval == '')
			return FALSE;
		return TRUE;
	}

	function HandlePages()
	{
		if ($this->checkIsPost('_csv_import_files_next', 'next')) {
			if (empty($_FILES['csv_import']['tmp_name'])) {
				$this->error = "No file uploaded";
				$this->step1 = TRUE;
				return;
			} else {

				$this->filename = dirname(__FILE__) . '/myfile.csv';
				move_uploaded_file($_FILES['csv_import']['tmp_name'], $this->filename);
				if (!file_exists($this->filename) || !is_readable($this->filename)) {
					$this->error = "Can not open/read uploaded file.";
					$this->step1 = TRUE;
					return;
				}
				$this->delimiter = $_POST['field-delimiter'];
				$this->insertype = $_POST['post_format'];
				update_option(self::ODELIMITER, $this->delimiter);
				update_option(self::OTYPE, $this->insertype);
				$this->step2 = TRUE;
			}
		} elseif ($this->checkIsPost('_csv_import_files_next1', 'next2')) {
			if ($this->checkIsPost('submitback', 'Back')) {
				$this->step1 = TRUE;
				return;
			}

			$this->filename = dirname(__FILE__) . '/myfile.csv';
			$this->delimiter = get_option(self::ODELIMITER, ',');
			$this->insertype = get_option(self::OTYPE);
			$columns = get_option(self::ONUMBERFIELDS);
			$alloptions = array();
			for ($i = 0; $i < $columns; $i++) {
				$val = '';
				if ($this->GetPost("field$i", $val)) {
					if (!in_array($val, $alloptions)) {
						$alloptions[] = $val;
					} else {
						$this->error = "Post field(s) mapped more than once !";
						$this->step2 = TRUE;
						return;
					}
					$this->mapped[$i] = $val;
				}
			}
			// $hast = false;
			// $hasc = false;
			// foreach ($this->mapped as $key => $value) {
			// 	if ($value == 'post_title') $hast = true;
			// 	if ($value == 'post_content') $hasc = true;
			// }
			// if (!$hasc || !$hast) {
			// 	$this->error = "Mandatory fields Post Title and\or Post Content not mapped!";
			// 	$this->step2 = TRUE;
			// 	return;
			// }
			$this->step3 = TRUE;
		} else {
			//default
			$this->step1 = TRUE;
		}
	}




	function main()
	{
		$this->HandlePages();
		if ($this->step1) :  ?>
			<div class="wrap">
				<h2>
					Import CSV Files
				</h2><br />
				<?php if ($this->error !== '') :  ?>
					<div class="error">
						<?php echo $this->error; ?>
					</div>
				<?php endif; ?>
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data">
					<input name="_csv_import_files_next" type="hidden" value="next" />
					<input id="post-format-0" class="post-format" type="hidden" value="interview" name="post_format">

					<!-- File input -->
					<p>
						<label for="csv_import">
							Select a CSV file:
						</label><br />
						<input name="csv_import" id="csv_import" type="file" value="" />
					</p>
					<!-- Type -->
					<p>
						<div id="formatdiv" class="postbox" style="display: none;max-width:350px;">
							<h3 class="hndle" style="cursor:auto;padding:10px;">
								<span>
									Select Import Type
								</span>
							</h3>
							<div class="inside">
								<div id="post-formats-select">

									<input id="post-format-0" class="post-format" type="radio" checked="checked" value="interview" name="post_format">
									<label class="post-format-icon post-format-standard" for="post-format-0">
										Interviews
									</label>
									<br>


									<input id="post-format-0" class="post-format" type="radio" value="post" name="post_format">
									<label class="post-format-icon post-format-standard" for="post-format-0">
										Posts
									</label>
									<br>
									<input id="post-format-page" class="post-format" type="radio" value="page" name="post_format">
									<label for="post-format-page">
										&nbsp;&nbsp;Pages
									</label>
									<br>
									<!--<input id="post-format-taxonomy" class="post-format" type="radio" value="taxonomy" name="post_format">
						<label for="post-format-taxonomy">
							&nbsp;&nbsp;Custom Taxonomies
						</label>
						<br>-->
								</div>
							</div>
						</div>
					</p>
					<p>
						<div id="formatdiv" class="postbox" style="display: block;max-width:350px;">
							<h3 class="hndle" style="cursor:auto;padding:10px;">
								<span>
									Select Field Delimiter
								</span>
							</h3>
							<div class="inside">
								<div id="post-formats-select">
									<select name="field-delimiter">
										<option value=",">comma ( , )</option>
										<option value=";">semicolon ( ; )</option>
										<option value="	">tab ( &nbsp;&nbsp;&nbsp;&nbsp; )</option>
									</select>
								</div>
							</div>
						</div>
					</p>
					<p class="submit">
						<input type="submit" class="button" name="submit" value="Next >" />
					</p>
				</form>
			</div>

		<?php elseif ($this->step2) : ?>
			<div class="wrap">
				<h2>
					Import CSV Files
				</h2>
				<?php if ($this->error !== '') :  ?>
					<div class="error">
						<?php echo $this->error; ?>
					</div>
				<?php endif; ?>
				<h3>Step 2 - Map Fields</h3><br />
				<p>Data Preview /fields display up to 30 characters/</p>
				<div style="overflow:auto;/*width:800px;*/">
					<?php
					$c = 0;
					$d = $this->delimiter;
					$e = '';
					$l = 9999999;

					//	        $res = fopen($this->filename, 'r');
					ini_set("auto_detect_line_endings", true);
					$res = $this->fopen_utf8($this->filename);
					if ($res == 0) return;
					$headers = array();
					$rows = array();
					while ($keys = fgetcsv($res, $l, $d)) {
						$str = implode("", $keys);
						trim($str);
						if (mb_strlen($str) === 0)
							continue;
						if ($c == 0) {
							$headers = $keys;
						} else {
							array_push($rows, $keys);
						}
						if ($c == 5) {
							break;
						}
						$c++;
					}

					fclose($res);
					ini_set("auto_detect_line_endings", false);
					$c = 0;
					echo '<table class="widefat" >';
					$number_of_fields = 0;
					$number_of_fields = count($headers);
					echo '<thead>
				    <tr>';
					for ($i = 0; $i < $number_of_fields; $i++) {
						$string = $headers[$i];

						if (mb_strlen($string) > 30) {
							$string = substr($string, 0, 30);
						}
						$string = str_replace(" ", "&nbsp;", $string);
						echo "<th><b>" . $string . "</b></th>";
					}
					echo '</tr>
				</thead>';
					echo '<tbody>';
					foreach ($rows as $row) {
						$number_of_fields = count($row);
						echo '<tr>';

						for ($i = 0; $i < $number_of_fields; $i++) {
							$string = $row[$i];

							if (strlen($string) > 30) {
								$string = substr($string, 0, 30);
							}
							$string = str_replace(" ", "&nbsp;", $string);
							echo "<td>" . $string . "</td>";
						}

						echo '</tr>';
						$c++;
					}
					echo '</tbody></table>';

					?>
				</div><br />
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data">
					<input name="_csv_import_files_next1" type="hidden" value="next2" />
					<!-- Type -->
					<p>
						<div id="formatdiv" class="postbox" style="display:none;max-width:600px;">
							<h3 class="hndle" style="cursor:auto;padding:10px;">
								<span>
									Map fields from the .csv file to post fields
								</span>
							</h3>
							<div class="inside">
								<div style="float:right;background-color:#FFFFE0;border: 1px solid #E6DB55;padding:10px;"><b>Note!</b> Post title<br /> and content are <br />mandatory fields.</div>
								<div id="post-formats-select">

									<?php
									$number_of_fields = count($headers);
									update_option(self::ONUMBERFIELDS, $number_of_fields);
									for ($i = 0; $i < $number_of_fields; $i++) {
										$string = $headers[$i];

										if (empty($string)) {
											continue;
										}

										echo "<p><div style=\"width:250px;float:left;\"><b>" . $string . '</b></div>';
										$extra = '';

										echo "<select name=\"field$i\">
											  <option value=\"\">Select...</option>
											  <option value=\"post_title\">Post Title </option>
											  <option value=\"post_content\">Post Content </option>
											  <option value=\"post_excerpt\">Post Excerpt </option>
										      <option value=\"post_status\">Post Status </option>" . $extra . "										      
											  <option value=\"post_date\">Post Date</option>
											</select></p>";
									}
									?>

								</div>
							</div>

						</div>
					</p>
					<!-- Type -->
					<p>
						<div id="formatdiv" class="postbox" style="max-width:600px;">
							<h3 class="hndle" style="cursor:auto;padding:10px;">
								<span>
									Use these settings if <b>not found\mapped</b> in the .csv file
								</span>
							</h3>
							<div class="inside">
								<div>
									Post Status:
									<select name="post_status_user">
										<option value="draft">Draft</option>
										<option value="publish">Publish</option>
										<option value="private">Private</option>
										<option value="pending">Pending</option>
									</select>&nbsp;&nbsp;&nbsp;&nbsp;
									<?php if ($this->insertype == 'post') : ?>
										Organize into category <?php wp_dropdown_categories(array('show_option_all' => 'Select one ...', 'hide_empty' => 0, 'hierarchical' => 1, 'show_count' => 1, 'name' => 'import_csvfile_cat')); ?>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</p>
					<p class="submit">
						<input type="submit" class="button" name="submitback" value="Back" />&nbsp;&nbsp;&nbsp;
						<input type="submit" class="button" name="submit" value="Next >" />
						<div style="/*float:right;*/background-color:#FFFFE0;border: 1px solid #E6DB55;padding:10px;">After clicking <b>Next</b>, the import process may take some time to complete. Do not navigate to another page or hit Refresh!</div>
					</p>
				</form>
			</div>
		<?php else : ?>
			<div class="wrap">
				<h1>Report</h1>
				<br />
				<?php
				$time_start = microtime(true);
				$tz = get_option('timezone_string');
				if ($tz && function_exists('date_default_timezone_set')) {
					date_default_timezone_set($tz);
				}
				$c = 0;
				$d = $this->delimiter;
				$l = 999999;
				$skipped = 0;
				$imported = 0;
				ini_set("auto_detect_line_endings", true);
				$res = $this->fopen_utf8($this->filename);
				if ($res == 0) return;

				$columns = [];
				while ($keys = fgetcsv($res, $l, $d)) {

					//print_r($keys);

					if ($c == 0) {

						$columns = array_values($keys);
						$str = implode("", $keys);
						trim($str);
						if (mb_strlen($str) === 0)
							continue;
					} else {
						$number_of_fields = count($keys);
						$data = array();
						//foreach ($this->mapped as $item => $value) {
						foreach ($columns as $item => $value) {
							$data[$value] = $keys[$item];
						}
						$new_post = array();
						$this->GetValuesFromArray($data, $new_post);

						// echo "<pre>";
						// print_r($new_post);
						// echo "</pre>";
						// exit;
						//$this->create_or_get_categories($data, $new_post);

						$id = wp_insert_post($new_post);

						$key =   $this->plugin_prefix . "hobbies";
						delete_post_meta($id, $key);
						if (isset($new_post["meta_input"][$key])) {

							foreach ($new_post["meta_input"][$key] as $value) {

								add_post_meta($id, $key, $value);
							}
						}

						unset($new_post);
						unset($data);
						if ($id)
							$imported++;
						else
							$skipped++;
					}
					$c++;
				}

				fclose($res);
				ini_set("auto_detect_line_endings", true);
				$exec_time = microtime(true) - $time_start;
				echo '<div class="updated fade">';
				echo sprintf(" Posts <b>imported</b> - <b>%d</b><br><br>", $imported);
				echo sprintf(" Posts <b>skipped</b> - <b>%d</b><br><br>", $skipped);
				echo sprintf("Finished in <b>%.2f</b> seconds.", $exec_time);
				echo '</div>';
				if (file_exists($this->filename)) {
					//@unlink($this->filename);
				}
				?>
			</div>
<?php endif;
	}
}

function giw3_admin_actions()
{
	$plugin = new GIW3ImportCSVFiles;
	//add_management_page("Import CSV Files", "Import CSV Files", "post_type=interview", "import_csv_files", array($plugin, 'main'));

	add_submenu_page(
		'edit.php?post_type=interview',
		'Import CSV Files',
		'Import CSV Files',
		'manage_options',
		'import_csv_files',
		array($plugin, 'main')
	);


	$post = ["a" => 1];

	$post = [
		'post_status' => 'draft',
		'meta_input' => [
			'kps-interviews_first_name' => 'Deven',
			'kps-interviews_last_name' => 'Sitapara',
			'kps-interviews_email' => 'dev@dev1.com',
			'kps-interviews_hobbies_1' => 'tv',
			'kps-interviews_hobbies_2' => 'reading',
			'kps-interviews_hobbies_3' => 'coding',

		],
		'post_type' => 'interview',
	];

	//wp_insert_post($post);

	// wp_insert_post(array(
	// 	'post_type'     => 'interview',
	// 	'meta_input'    => array(
	// 		array(
	// 			'key'   => 'hobbies',
	// 			'value' => ["tv", "coding", "reading"]
	// 		),
	// 		array(
	// 			'key'   => 'first_name',
	// 			'value' => "tmp"
	// 		)
	// 	)
	// ));
}

add_action('admin_menu', 'giw3_admin_actions');
