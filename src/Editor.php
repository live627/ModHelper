<?php

namespace ModHelper;

/**
 * This file deals with the richtext editor widget since we will need this in several places and it's better to reuse.
 *
 * @package ModHelper
 * @since 1.0
 */
class Editor
{
	private $id;
	private $sanitized = '';

	public function __construct($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function initialize($editorOptions)
	{
		global $sourcedir, $context;
		require_once($sourcedir . '/Subs-Editor.php');
		$defaults = array(
			'id' => $this->id,
			'value' => '',
			'height' => '175px',
			'width' => '100%',
			'preview_type' => 0,
		);
		$editorOptions = array_merge($defaults, $editorOptions);
		create_control_richedit($editorOptions);

		if (isset($editorOptions['js'])) {
			$context['controls']['richedit'][$editorOptions['id']]['js'] = $editorOptions['js'];
		}
	}

	public function outputEditor()
	{
		global $context;
		if ($context['show_bbc']) {
			echo '
				<div id="bbcBox_', $this->id, '"></div>';
		}
		if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup'])) {
			echo '
				<div id="smileyBox_', $this->id, '"></div>';
		}
		echo '
				', template_control_richedit($this->id, 'smileyBox_' . $this->id, 'bbcBox_' . $this->id);
	}

	public function outputButtons()
	{
		global $context, $txt;
		// We would use SMF's template_control_richedit_buttons if it weren't useless to us and not customisable.
		$editor_context = & $context['controls']['richedit'][$this->id];
		echo '
				<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				<p id="post_confirm_buttons" class="righttext">
					<input type="submit" value="', isset($editor_context['labels']['post_button']) ? $editor_context['labels']['post_button'] : $txt['post'], '" tabindex="', $context['tabindex']++, '"', isset($editor_context['js']['post_button']) ? ' onclick="' . $editor_context['js']['post_button'] . '"' : '', ' class="button_submit" />';
		if ($editor_context['preview_type']) {
			echo '
					<input type="submit" name="preview" value="', isset($editor_context['labels']['preview_button']) ? $editor_context['labels']['preview_button'] : $txt['preview'], '" tabindex="', $context['tabindex']++, '"', isset($editor_context['js']['preview_button']) ? ' onclick="' . $editor_context['js']['preview_button'] . '"' : '', ' class="button_submit" />';
		}
		echo '
				</p>';
	}

	private function prepareWYSIWYG()
	{
		global $sourcedir;
		if (!empty($_REQUEST[$this->id . '_mode']) && isset($_REQUEST[$this->id])) {
			require_once($sourcedir . '/Subs-Editor.php');
			$_REQUEST[$this->id] = html_to_bbc($_REQUEST[$this->id]);
			$_REQUEST[$this->id] = un_htmlspecialchars($_REQUEST[$this->id]);
			$_POST[$this->id] = $_REQUEST[$this->id];
		}
	}

	public function isEmpty()
	{
		global $smcFunc;
		$this->prepareWYSIWYG();

		return (empty($_POST[$this->id]) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST[$this->id]), ENT_QUOTES) === '');
	}

	public function sanitizeContent()
	{
		global $smcFunc, $sourcedir;
		require_once($sourcedir . '/Subs-Post.php');
		preparsecode($this->sanitized = $smcFunc['htmlspecialchars']($_POST[$this->id], ENT_QUOTES));

		return !($smcFunc['htmltrim'](strip_tags(parse_bbc($this->sanitized, false), '<img>')) === '' && (!allowedTo('admin_forum') || strpos($this->sanitized, '[html]') === false));
	}

	public function getForDB()
	{
		return $this->sanitized;
	}

	public function getForForm($comment = null)
	{
		global $sourcedir;
		require_once($sourcedir . '/Subs-Post.php');
		censorText(un_preparsecode($comment === null ? $this->sanitized : $comment));

		return str_replace(array('"', '<', '>', '&nbsp;'), array('&quot;', '&lt;', '&gt;', ' '), $comment);
	}
}

?>