<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	public $pedidos =[
		'descripcion' => 'required|min_length[3]|max_length[255]',
		'npedimento' => 'min_length[3]|max_length[255]',
		'psalida' => 'min_length[3]|max_length[255]',
		'pdestino' => 'min_length[3]|max_length[255]',
		'estatus' => 'min_length[3]|max_length[255]',
		'fechapedido' => 'min_length[3]|max_length[255]',
		'hora' => 'min_length[3]|max_length[255]',
		'image_url' => 'min_length[3]|max_length[255]'
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
