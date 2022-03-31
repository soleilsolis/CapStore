<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorMessages extends Controller
{
    public function data($data, $modal = null, $changeSend = array(), $enable = array(), $disable = array(), $remove = array(), $custom = 0, $message = null,$hidden = array(),$unhidden = array())
	{
		$this->json = [
			'data' => $data,
			'custom' => $custom
		];
		
		if($changeSend)
		{
			$this->json['changeSend'] = $changeSend;
		}
		
		if($enable)
		{
			$this->json['enable'] = $enable;
		}
		
		if($disable)
		{
			$this->json['disable'] = $disable;
		}
		
		if($modal)
		{
			$this->json['modal'] = $modal;
		}
		
		if($remove)
		{
			$this->json['remove'] = $remove;
		}

		if($hidden)
		{
			$this->json['hidden'] = $hidden;
		}

		if($unhidden)
		{
			$this->json['unhidden'] = $unhidden;
		}
		
		return response()->json($this->json);
	}

	public static function customAlert($message = '', $reload = 0, $color = '', $enable = array(), $disable = array(), $data = array(), $hidden=array(),$dimmer_click = 0)
	{
		return response()->json([
			'message' => $message,
			'reload' => $reload,
			'color' => $color,
			'enable' => $enable ?? null,
			'disable' => $disable ?? null,
			'data' => $data,
			'hidden' => $hidden,
			'dimmer_click' => $dimmer_click
		]);
	}

	public function errors($errors, $message = null, $color = null)
	{
		$this->json = [
			'errors' => $errors,
		];

		if($message)
		{
			$this->json['message'] = $message;
		}

		if($color)
		{
			$this->json['color'] = $color;
		}

		return response()->json($this->json);
	}

	public function fileNotSupported($fields = array())
	{
		return response()->json([
			'message' => 'File not supported',
			'color' => 'error',
			'errors' => $fields
		]);
	}

	public function fileTooLarge($fields = array())
	{
		return response()->json([
			'message' => 'File is too large. Max file size = 2MB',
			'color' => 'error',
			'errors' => $fields
		]);
	}

	public function redirect($url = null)
	{
        return response()->json([
			'redirect' => 1,
			'url' => $url,
		]);
    }

    public function reload()
	{
        return response()->json([
			'reload' => 1,
		]);
    }
}
