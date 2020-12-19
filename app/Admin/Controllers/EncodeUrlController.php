<?php

namespace App\Admin\Controllers;


use App\Dictionary\BaseEncoder;
use App\Facades\UrlEncoder;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form;
use Faker\Provider\Base;
use Illuminate\Http\Request;

/**
 * Class EncodeUrlController
 * @package App\Admin\Controllers
 */
class EncodeUrlController extends Controller
{

    /**
     * @param Content $content
     * @return $this
     */
    public function index(Content $content)
    {
        return $content
            ->header('Custom Url Encoder')
            ->body($this->urlEncodingForm());
    }

    /**
     * @return Form
     *
     * To create a custom form for user inputs
     */
    public function urlEncodingForm()
    {
        $form = new Form();

        //To declare options @ form
        $options = [BaseEncoder::ENCODE, BaseEncoder::DECODE];

        $form->select('action', 'Action')->options(array_combine($options, $options))->required();
        $form->url('url', 'URL')->required();
        return $form;
    }

    /**
     * @param Request $request
     *
     * To handle the inputs selected by the user in form
     */
    public function post(Request $request)
    {
        $url = $request->url;

        switch ($request->action) {
            case BaseEncoder::ENCODE:
                $result = UrlEncoder::encode($url);
                break;
            case BaseEncoder::DECODE:
                $result = UrlEncoder::decode($url);
                break;
            default:
                $url = null;
        }

        admin_success('Success', $result);
    }
}