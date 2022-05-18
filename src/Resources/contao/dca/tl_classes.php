<?php


use Contao\DataContainer;
use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_classes'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => DC_Table::class,
		'ptable'                      => 'tl_theme',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'markAsCopy'                  => 'name',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => DataContainer::MODE_PARENT,
			'fields'                  => array('name'),
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => array('name', 'author', 'tstamp'),
			'child_record_callback'   => array('tl_classes', 'listClasses')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(

			'edit' => array
			(
				'href'                => 'table=tl_classes&amp;act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},name,cssClass;{showLegend},showOnPage,showOnArticle,showOnElement'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_theme.name',
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'name' => array
		(
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => true,
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NULL"
		),
		'cssClass' => array
		(
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'showOnPage' => [
            'inputType'               => 'checkbox',
            'exclude'                 => true,
			'eval'                    => array('tl_class'=>'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
        ],
        'showOnArticle' => [
            'inputType'               => 'checkbox',
            'exclude'                 => true,
			'eval'                    => array('tl_class'=>'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
            ],
        'showOnElement' => [
            'inputType'               => 'checkbox',
            'exclude'                 => true,
			'eval'                    => array('tl_class'=>'w50 m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
        ],
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @internal
 */
class tl_classes extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import(BackendUser::class, 'User');
	}

	/**
	 * List an image size
	 *
	 * @param array $row
	 *
	 * @return string
	 */
	public function listClasses($row)
	{
		$html = '<div class="tl_content_left">';
		$html .= $row['name'];

		$html .= ' <span style="color:#999;padding-left:3px;font-family:monospace">[ .' . $row['cssClass'] . ' ]</span>';
        
        $html .= ($row['showOnPage']) ? '<span style="color:#999;padding-left:3px;">P</span>' : '';
        $html .= ($row['showOnArticle']) ? '<span style="color:#999;padding-left:3px;">A</span>' : '';
        $html .= ($row['showOnElement']) ? '<span style="color:#999;padding-left:3px;">P</span>' : '';

		$html .= "</div>\n";

		return $html;
	}

	/**
	 * Return the edit header button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return System::getContainer()->get('security.helper')->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELDS_OF_TABLE, 'tl_classes') ? '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)) . ' ';
	}

	/**
	 * Return the image format options
	 *
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function getFormats(DataContainer $dc=null)
	{
		$formats = array();
		$missingSupport = array();

		if ($dc->value)
		{
			$formats = StringUtil::deserialize($dc->value, true);
		}

		foreach ($this->getSupportedFormats() as $format => $isSupported)
		{
			if (!in_array($format, System::getContainer()->getParameter('contao.image.valid_extensions')))
			{
				continue;
			}

			if (!$isSupported)
			{
				$missingSupport[] = $format;

				continue;
			}

			$formats[] = "png:$format,png";
			$formats[] = "jpg:$format,jpg;jpeg:$format,jpeg";
			$formats[] = "gif:$format,gif";
			$formats[] = "$format:$format,png";
			$formats[] = "$format:$format,jpg";
		}

		if ($missingSupport)
		{
			$GLOBALS['TL_DCA']['tl_classes']['fields']['formats']['label'] = array
			(
				$GLOBALS['TL_LANG']['tl_classes']['formats'][0],
				sprintf($GLOBALS['TL_LANG']['tl_classes']['formatsNotSupported'], implode(', ', $missingSupport)),
			);
		}

		$options = array();
		$formats = array_values(array_unique($formats));

		foreach ($formats as $format)
		{
			list($first) = explode(';', $format);
			list($from, $to) = explode(':', $first);
			$chunks = array_values(array_diff(explode(',', $to), array($from)));

			$options[$format] = strtoupper($from) . ' → ' . strtoupper($chunks[0]);
		}

		return $options;
	}

	/**
	 * Check if WEBP, AVIF, HEIC or JXL is supported
	 *
	 * @return array
	 */
	private function getSupportedFormats()
	{
		$supported = array
		(
			'webp' => false,
			'avif' => false,
			'heic' => false,
			'jxl' => false,
		);

		$imagine = System::getContainer()->get('contao.image.imagine');

		if ($imagine instanceof ImagickImagine)
		{
			foreach (array_keys($supported) as $format)
			{
				$supported[$format] = in_array(strtoupper($format), Imagick::queryFormats(strtoupper($format)), true);
			}
		}

		if ($imagine instanceof GmagickImagine)
		{
			foreach (array_keys($supported) as $format)
			{
				$supported[$format] = in_array(strtoupper($format), (new Gmagick())->queryformats(strtoupper($format)), true);
			}
		}

		if ($imagine instanceof GdImagine)
		{
			foreach (array_keys($supported) as $format)
			{
				$supported[$format] = function_exists('image' . $format);
			}
		}

		return $supported;
	}
}