<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use VaahCms\Modules\Cms\Entities\MenuItem;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;
use Faker\Factory;

class WelcomeController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_theme_slug();
    }

    //----------------------------------------------------------
    public function clearCache(Request $request)
    {
        $response = VaahArtisan::clearCache();
        if($response['status'] == 'failed')
        {
            return $response;
        }

        try{
            $files = ['config.php', 'packages.php', 'services.php'];
            $path = base_path().'/bootstrap/cache/';
            foreach ($files as $file)
            {
                if(\File::exists($path.$file))
                {
                    \File::delete($path.$file);
                }
            }

            $response['status'] = 'success';
            $response['messages'][] = 'Cache was successfully deleted.';

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;

    }
    //----------------------------------------------------------
    public function index()
    {


        $errors = [];
        $is_cms_exists = Module::slug('cms')->active()->exists();

        if(!$is_cms_exists)
        {
            $errors[] = 'Install and activate the CMS module or Define your own routes.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->exists();

        if(!$is_theme_active)
        {
            $errors[] = 'Install and activate a theme.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $is_theme_active = Theme::active()->count();

        //if CMS module is not installed or active
        if($is_theme_active < 1)
        {
            $errors[] = 'No theme is marked as active.';
            return view($this->theme.'::frontend.welcome')->withErrors($errors);
        }

        $menu_item = MenuItem::getHomePage();

        if(!$menu_item)
        {
            //check if dedicated welcome page is exist
            if (view()->exists($this->theme.'::frontend.welcome')) {
                return view($this->theme.'::frontend.welcome');
            } else {
                return view('vaahcms::frontend.theme-welcome');
            }
        }

        $blade = $menu_item->content->theme->slug.'::'.$menu_item->content->template->file_path;

        return view($blade)->with('data', $menu_item->content);
    }

    //----------------------------------------------------------
    public function getFaker(Request $request)
    {

        $rules = array(
            'model_namespace' => 'required',
        );

        $messages = [
            'model_namespace.required' => "model_namespace is required. Eg: WebReinvent\VaahCms\Entities\User"
        ];

        $validator = \Validator::make( $request->all(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $model = $request->model_namespace;

        $model = new $model();

        $table = $model->getTable();

        if($request->filled('fillable'))
        {
            $fillable = $request->fillable;
        } else{
            $fillable = $model->getFillable();
        }

        if($request->filled('except'))
        {
            $except = $request->except;
            $fillable = array_diff($fillable,$except);
        };

        $faker = Factory::create();

        $fill = [];
        $list = [];

        $i = 0;
        foreach ($fillable as $column)
        {
            $type = \DB::getSchemaBuilder()->getColumnType($table, $column);
            $value = null;

            switch($type)
            {
                case 'text':
                $value = $faker->text(60);
                    break;

                case 'string':
                    $value = $faker->text(25);
                    break;

                case 'boolean':
                    $value = array_rand([0,1]);
                    break;



            }

            $list[$i]['column'] = $column;
            $list[$i]['type'] = $type;
            $list[$i]['value'] = $value;
            $fill[$column] = $value;
            $i++;

        }


        foreach ($fill as $column => $value)
        {
            switch ($column){

                case 'first_name':
                    $fill[$column] = $faker->firstName;
                    break;

                case 'last_name':
                case 'middle_name':
                    $fill[$column] = $faker->lastName;
                    break;

                case 'email':
                    $fill[$column] = $faker->email;
                    break;

                case 'username':
                    $fill[$column] = $faker->userName;
                    break;

                case 'slug':
                    if(isset($fill['name']) && !empty($fill['name']))
                    {
                        $fill[$column] = Str::slug($fill['name']);
                    }
                    break;

                case 'created_by':
                case 'updated_by':
                    $fill[$column] = User::inRandomOrder()->first()->id;
                    break;

            }
        }


        $data['fill']=$fill;
        $data['list']=$list;

        $response['success'] = true;
        $response['data'] = $data;
        return $response;


    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
