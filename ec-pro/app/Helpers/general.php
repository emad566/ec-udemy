<?php
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAGINATION_COUNT', 10);
function delete_img($img_path){
    if (file_exists($img_path)) {
        unlink($img_path);
    }
}


// function getFolder()
// {

//     return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
// }


// function uploadImage($folder,$image){
//     $image->store('/', $folder);
//     $filename = $image->hashName();
//     return  $filename;
//  }





function updateIsActive($obj, $table, $name='is_active', $field=''){
    $checked = ($obj->$name)? 'checked' : '';
    $route = $table;
    $route .= ($name=='is_active')? '.updateIsActive' : '.update'.$name;

    if(is_array($field) && array_key_exists(5,$field)){
        $route = $field[5];
    }
    if(is_array($field) && array_key_exists(4,$field)){
        $checked = ($obj->$name == $field[4])? 'checked' : '';
    }

    $html = '';

    $html .= '<input '.$checked .' action="'. route($route,$obj->id) .'" type="checkbox" formid="'. $obj->id .'" name="'.$name.'" id="'.$name.'"  class="'.$name.' switcher updateIsActive">';
    return $html;
}

function indexEdit($obj, $table, $vars=false)
{
    if(!$vars) $vars = [$obj->id];
    $routs = route($table.'.edit', $vars);
    $html = '<a href="'.$routs.'"><i class="fas fa-edit delEdit"></i></a>';
    return $html;
}

function indexView($obj, $table, $vars=false)
{
    if(!$vars) $vars = [$obj->id];
    $routs = route($table.'.show', $vars);
    $html = '<a href="'.$routs.'"><i class="fas fa-eye delEdit"></i></a>';
    return $html;
}

// function indexImg($obg)
// {
//     $html ='';
//     if($obg->img && file_exists($obg->imgUrl(true))){
//         $html .= ' <img class="thumb" src="'.$obg->imgUrl().'" alt="">';
//     }
//     return $html;
// }

function indexDel($data)
{
    extract($data);
    if(!isset($noview)) $noview = '';
    if($nodel) return "";
    if(!isset($del)) return 'Pls Pass del Obj';
    if(!isset($trans)) $trans = "deleteitemNote";
    if(!isset($title)) $title = 'title';
    if(!isset($indexDel)) $indexDel = true;
    if(!isset($vars)) $vars = [$del->id];


    $str = get_class($del);
    $strArr = explode("\\", $str);
    $objname = end($strArr);
    if(!isset($table)) $table = strtolower($objname) .'s';

    $html ='';
    if($indexDel){
        $html .= '
        <a href="'.route($table.'.destroy',$del->id).'"
            msg="'. trans('main.'.$trans) .'  '. $del->$title .'"
            class="deleteMe"
        ><i class="fas fa-trash-alt delEdit"></i></a>
        ';
    }

    return $html;
}

function indexTableHead($fields, $type='thead', $active=true, $action=true, $indexDel)
{
    $html = '<'. $type .'>';
    $html .= '
        <tr>
            <th>';

    if($indexDel){
        $html .= '<input type="checkbox" name="allItems" value="1" id="allItems" class="allItems">';
    }

    $html .='#id</th>';



    if($action)
        $html .= '<th>'. trans('main.Actions') .'</th>';

    foreach($fields as $field){
        $html .= '<td>'. trans('main.'.$field[2]) .'</td>';
    }

    if($active)
        $html .= '<th>'. trans('main.Active') .'</th>';

    if($action)
        $html .= '<th>'. trans('main.Actions') .'</th>';

    $html .= '</tr>
    ';
    return $html .= '<'. $type .'/>';
}

function indexTableTds($obj, $fields, $table, $indexDel)
{
    // $abbr is the logo lang abbriviation
    $html = '';
    foreach($fields as $field){
        $attr = $field[0];
        $html .= '<td>';

        if(is_array($field[0])){
            $fieldArr = $field[0];
            if(array_key_exists($obj->id,$fieldArr)){
                $html .= $fieldArr[$obj->id];
            }
        }elseif(array_key_exists(3,$field) && $field[3] == 'check') {
            $html .= updateIsActive($obj, $table, $field[0], $field);
        }elseif(array_key_exists(3,$field) && $field[3] == 'trans') {
            $html .= trans('main.'.$obj->$attr);
        }else{
            if($field[1])
                $html .= $obj->$attr;
            else{
                $attrArr = explode('->', $attr);
                $value = $obj;
                foreach($attrArr as $key=>$attr){
                    // $value .= $attr;
                    if($value){
                        if(strpos($attr, '()')){
                            $attr = str_replace('()', '', $attr);
                            $value = $value->$attr();
                        }else
                            $value = $value->$attr;
                    }else
                        $value = "";
                }
                $html .= $value;
            }
        }
        $html .= '</td>';
    }
    return $html;

}

function indexTable($data)
{
    //$objs, $table, $title, $trans, $vars, $fields
    //$abbr is the logo lang abbriviation

    extract($data);
    if(!isset($noview)) $noview = '';
    if(!isset($objs)) return 'Pls Pass objs';
    if(!isset($trans)) $trans = "deleteitemNote";
    if(!isset($title)) $title = 'title';
    if(!isset($abbr)) $abbr = false;
    if(!isset($vars)) $vars = false;
    if(!isset($logo_abbr)) $logo_abbr = true;
    if(!isset($nodel)) $nodel = false;
    if(!isset($active)) $active = true;
    if(!isset($action)) $action = true;
    if(!isset($indexEdit)) $indexEdit = true;
    if(!isset($indexDel)) $indexDel = true;
    if(!isset($isread)) $isread = false;
    if(!isset($view)) $view = false;




    $html = '';
    $html .= '
    <table class="table display nowrap table-striped table-bordered datatable">
        '.indexTableHead($fields, 'thead', $active, $action, $indexDel).'
        <tbody>
    ';

    $i=1;

    if(isset($objs)){
        foreach($objs as $obj){
            if(is_array($vars)){
            $varsArr = $vars;
            array_push($varsArr, $obj->id);
            }else{
                $varsArr = '';
            }
            if($i == 1){
                $str = get_class($obj);
                $strArr = explode("\\", $str);
                $objTitle = end($strArr);
                if(!isset($table)) $table = strtolower($objTitle) .'s';
                if(!isset($objname)) $objname = strtolower($objTitle);
            }


            $html .='<tr class="rowAction">
            <td>';
            if($indexDel){
                $html .= '<input type="checkbox" name="'.$table.'[]" value="'.$obj->id.'" class="boxItem">';
            }
            $html .= $i.'</td>';

            if($action){

            $html .='<td class="actionLinks">';
            if($indexEdit){
                $html .=  indexEdit($obj, $table, $varsArr);
            }
            if($view){
                $html .=  indexview($obj, $table, $varsArr, $abbr);
            }
                $html .=  indexDel(['del'=>$obj, 'table'=>$table, 'title'=>$title, 'indexDel'=>$indexDel, 'vars'=>$varsArr, 'trans'=> $trans, 'nodel'=>$nodel]) .'
            </td>';
            }

            $html .= indexTableTds($obj, $fields, $table, $indexDel);

            if($active){
            $html .='<td>

            '.updateIsActive($obj, $table).'

            </td>';
            }

            if($action){

            $html .='<td class="actionLinks">';
                if($indexEdit){
                    $html .=  indexEdit($obj, $table, $varsArr);
                }
                if($view){
                    $html .=  indexview($obj, $table, $varsArr);
                }
                $html .=  indexDel(['del'=>$obj, 'table'=>$table, 'title'=>$title, 'indexDel'=>$indexDel, 'vars'=>$varsArr, 'trans'=> $trans, 'nodel'=>$nodel]) .'
            </td>';
            }

            $html .='</tr>';
            $i++;
        }
    }

    $html .= '
    </tbody>
    ';
if($i>13)
    indexTableHead($fields, 'tfoot', $active, $action, false);

    $html .= '</table>
    ';
    if($indexDel){
        $html .= '
        <a href="" formId="delete-formMulti"
        class="deleteMe btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1"
        >'.trans('main.delete').'</a>
        ';
    }
    return $html;
}

// function cur_lang($active=true){
//     if($active){
//          $lang = Lang::where(['abbr'=> LaravelLocalization::getCurrentLocale(), 'is_active'=>1])->first();
//     }
//     else
//         $lang = Lang::where(['abbr'=> LaravelLocalization::getCurrentLocale()])->first();

//     // if(!$lang) return Lang::where(['abbr'=> 'ar'])->first();
//     return $lang;
// }

// function getSettings(){
//     // Artisan::call('view:clear');

//     try {
//         $setting = Setting::findOrFail(1);
//         return $setting;
//     } catch (\Exception $ex) {
//         return 'Error In general@getSettings';
//     }
// }








// function upload_image($file, $uplaodFolder, $oldImg = "")
// {
//     $photoName = time() . "-mwjood-" . $file->getClientOriginalName();
//     $directory = 'uploads/' . $uplaodFolder;

//     // If There error in the function file->move check, Search about start Emad in the file
//     // mwjood-laravel\vendor\symfony\http-foundation\File\UploadedFile.php
//     $file->move($directory, $photoName);

//     // Optimize Uploaded Image
//     $filepath = $directory . '/' . $photoName;
//     $cFilePath = $directory . '/' . $photoName;

//     $filesize = filesize($filepath);
//     if (($filesize / 1024)> getSettings()->optImgAtSize){

//         if (($filesize / 1024)> getSettings()->maxImgSize){
//             delete_img($filepath);
//             return back()->with('error', 'أقصي حجم مسموح به للصورة المرفوعة هو: ' . getSettings()->maxImgSize . "KB");
//         }

//         require_once "../mwjood-laravel/vendor/autoload.php";
//         if(@is_array(getimagesize($filepath))){
//             try {
//                 // \Tinify\setKey('env("TINIFY_API_KEY")'); // Alternatively, you can store your key in .env file.
//                 \Tinify\setKey("MDlwM0MYCjJ56FZyWPdtdpQKJhgJ6Dbx"); // Alternatively, you can store your key in .env file.

//                 $source = \Tinify\fromFile($filepath);
//                 $source->toFile($cFilePath);

//             } catch (\Tinify\AccountException $e) {
//                 return back()->with('error', 'Verify your API key and account limit.');
//             } catch (\Tinify\ClientException $e) {
//                 // Check your source image and request options.
//                 return back()->with('error', '$e->getMessage() Check your source image and request options.');
//             } catch (\Tinify\ServerException $e) {
//                 // Temporary issue with the Tinify API.
//                 return back()->with('error', 'Temporary issue with the Tinify API.');
//             } catch (\Tinify\ConnectionException $e) {
//                 // A network connection error occurred.
//                 return back()->with('error', 'A network connection error occurred');
//             } catch (Exception $e) {
//                 // Something else went wrong, unrelated to the Tinify API.
//                 return back()->with('error', 'Something else went wrong, unrelated to the Tinify API.');
//             }
//         }
//     }

//     // Delete old images
//     if ($oldImg) {
//         $old_path = $directory . '/' . $oldImg;
//         delete_img($old_path);
//     }

//     return $photoName;
// }



function getErrors($errors, $name, $noview = ''){
    $noview = ($noview)? '<span class="noview">'.trans('main.noview').'</span>' : '';

    $error = '';
    if (isset($errors) && $errors && $errors->count() > 0){
        if(is_object ($errors)){
            if($errors->default->get($name))
                $error .= $errors->default->get($name)[0];
        }
    }
    return $error .=$noview;
}

function input($data){
    //$type='text',$name, $trans, $errors, $edit=false, $childe=false, $cols=6, $maxlength=191,  $required="required"

    extract($data);
    if(!isset($view)) $noview = '';
    if(!isset($type)) $type = "text";
    if(!isset($edit)) $edit = false;
    if(!isset($cols)) $cols = 12;
    if(!isset($maxlength)) $maxlength = 191;
    if(!isset($required)) $required = "";

    if(!isset($attr)) $attr = "";
    if(!isset($class)) $class = "";
    if(!isset($label)) $label = true;
    if(!isset($fontclass)) $fontclass = "";
    if($fontclass) $fontclass = '<i class="inputI '.$fontclass.'"></i>';

    $value = ($edit)? $edit->$name : '';


    $html = '
    <div class="col-md-'.$cols.'">
        <div class="form-group">';
            if($label){
            $html .= '<label for="'.$name.'"> '.$fontclass.' '.trans('main.'.$trans).'</label>
            ';
            }

            $html .= ' <input maxlength='
                     .$maxlength.' '.$required.' type="'.$type
                     .'" value="'.$value.'" id="'.$name
                     .'" class="form-control '.$name.' '.$class.'" '
                     .$attr.' placeholder="'
                     .trans('main.'.$trans).'" name="'.$name.'">
            ';

            $html .=getErrors($errors, $name, $noview).'
        </div>
    </div>
    ';
    return $html;
}

// function textarea($data){
//     //$name, $trans, $errors, $edit=false, $childe=false, $cols=6, $maxlength=191,  $required="required"

//     extract($data);
//     if(!isset($noview)) $noview = '';
//     if(!isset($edit)) $edit = false;
//     if(!isset($childe)) $childe = false;
//     if(!isset($cols)) $cols = 6;
//     if(!isset($maxlength)) $maxlength = 5000;
//     if(!isset($required)) $required = "";
//     if(!isset($attr)) $attr = "";
//     if(!isset($class)) $class = "";

//     $value = getvalue($name, $edit, $childe);

//     $html = '
//     <div class="col-md-'.$cols.' '.$name.'">
//         <div class="form-group">
//             <label for="'.$name.'">'.trans('main.'.$trans).'</label>
//             <textarea maxlength='.$maxlength.' '.$required.' id="'.$name.'"
//                 class="form-control '.$name.' '.$class.'" '.$attr.' placeholder="'.trans('main.'.$trans).'"
//                 name="'.$name.'">'.$value.'</textarea>
//     ';

//     $html .=getErrors($errors, $name, $noview).'
//         </div>
//     </div>
//     ';
//     return $html;
// }

function getSrc($edit, $name)
{
    $img = $name;
    $imgSrc= $name.'Src';
    if($edit){
        if(file_exists($edit->$imgSrc())){
            return asset($edit->$imgSrc());
        }
    }
    return '';
}

function img($data){
    //$name, $trans, $errors, $edit=false, $childe=false, $cols=6, $required="required"
    extract($data);
    if(!isset($noview)) $noview = '';
    if(!isset($edit)) {$edit = false;}
    if(!isset($cols)) $cols = 6;
    if(!isset($required)) $required = "";
    if(!isset($name)) $name = "image";
    if(!isset($imgFrame)) $imgFrame = true;



    if($imgFrame){
        return imgFrame($data);
    }

    // $value = getvalue($name, $edit, $childe);
    $value = getvalue($name, $edit);
    $upload = ($edit)? '-upload':'';
    $src = getSrc($edit, $name, $childe);
    $create = ($edit)? "": 'create';

    $html = '
    <div class="col-md-'.$cols.'">
        <div class="form-group '.$create.' uploadbtnDiv">
            <label for="'.$name.'">'.trans('main.'.$trans).'
                <img id="thumb" class="thumb-sm'.$upload.'" src="'.$src.'" alt="" accept="image/x-png, image/gif, image/jpeg">
            </label>
            <input '.$required.'  type="file" accept="image/x-png, image/gif, image/jpeg"
                name="'.$name.'" id="'.$name.'" class="'.$name.' showupload uploadbtn">
            <p class="inputNotes">'.trans('main.AllowedImageExtensions').' (jpg, png, gif) </p>
    ';

    $html .=getErrors($errors, $name, $noview).'
        </div>
    </div>
    ';

    return $html;
}

function get_remote_file_info($url) {
    $localSrc = str_replace(url('/').'/', '', $url);
    if(file_exists($localSrc)){
        $imgsize = filesize($localSrc);
        return formatSizeUnits($imgsize);
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function imgFrame($data){
    //$name, $trans, $errors, $edit=false, $childe=false, $cols=6, $required="required"
    extract($data);
    if(!isset($noview)) $noview = '';
    if(!isset($edit)) {$edit = false;}
    if(!isset($cols)) $cols = 12;
    if(!isset($required)) $required = "";
    if(!isset($file)) $file = "";
    if(!isset($name)) $name = "image";
    if(!isset($src)) $src = "";

    if($required && $edit && $edit->$name){
        $required = '';
    }

    // $value = getvalue($name, $edit, $childe);
    $value = ($edit)? $edit->$name : '';
    $upload = ($edit)? '-upload':'';
    $src = getSrc($edit, $name);
    $imgsize = '';
    $imgname = '';

    if($src){
        $imgsize = get_remote_file_info($src);
        $imgname = $edit->$name;
    }

    $accept = ($file == 'pdf') ? 'accept=".pdf"' : 'accept="image/x-png, image/gif, image/jpeg"';

    $create = ($edit)? "": 'create';
    $html = '';
    $html .='
    <div class="form-group col-md-'.$cols.'">
        <label>'.trans('main.'.$trans).'</label>
        <div class="custom-ow-file">
            <div class="custom-ow-file-wrapper position-relative">
                <input type="file" img="img'.$name.'" id="'.$name.'" name="'.$name.'"
                    class="'.$name.' showupload '.$file.'uploadbtn" '. $required .'  '.$accept.'>
                <label class="position-absolute" for="'.$name.'">
                    <div class="me">
                        <span class="d-block">'.trans('main.DragFileHer').'</span>
                        <span class="d-block">'.trans('main.OrPressToSelect').'</span>
                    </div>
                </label>
            </div>
            <!--Image uploaded-->
            <div class="uploaded-image">
                <div class="row px-2">
                    <div class="col-12  px-0 px-md-1 create uploadbtnDiv">
            ';

            if($file == 'pdf'){
                $html .= '<a href="'.$src.'" class="pdfuploadbtn"><img id="thumb'.$upload.'" class="border-0 thumb-sm'.$upload.' img'.$name.'" src="'.url('/assets/images/pdf.png').'"></a>';
            }else{
                $html .= '<img id="thumb'.$upload.'" class="border-0 thumb-sm'.$upload.' img'.$name.'" src="'.$src.'"  '.$accept.'>';
            }

            $html .= '    <div class="img-up-details d-inline-block mt-1 img'.$name.'">
                            <i class="far fa-check-circle"></i>
                            <span class="d-inline-block img-up-name"
                                id="image_name">'.$imgname.'</span></br>
                            <span class="d-inline-block img-up-size">
                                <span class="d-inline-block">'.trans('main.FileSize').' :
                                </span>
                                <strong> <span class="d-inline-block"
                                        id="image_size">
                                            '.$imgsize.'
                                    </span></strong>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        '.getErrors($errors, $name, $noview).'
    </div>

    ';

    return $html;
}


function checkbox($data){
    //$name, $trans, $errors, $edit=false, $childe=false, $cols=6,

    extract($data);
    if(!isset($noview)) $noview = '';
    if(!isset($edit)) $edit = false;
    if(!isset($check)) $check = true;
    if(!isset($cols)) $cols = 12;
    if(!isset($required)) $required = "";
    if(!isset($label)) $label = true;
    if(!isset($class)) $class = true;

    $value = ($edit)? $edit->$name : '';

    $checked = ($check)? 'checked' : '';
    if(((old('_method') == 'PUT' || old('_method') == 'POST')) ){
        $checked = (old($name) == 1)? 'checked' : '';
    }elseif($edit){
        $checked = ($edit->$name == 1)? 'checked' : '';
    }

    $html = '
    <div class="col-md-'.$cols.'">
        <div class="form-group mt-1">
            <input type="checkbox" '.$required.' value="1" name="'.$name.'"
                id="switcheryColor4" class="switchery '.$class.' '.$name.'" data-color="success"
                '.$checked.' />';
    if($label){
            $html .= '<label for="'.$name.'" class="card-title ml-1 ">'.trans('main.'.$trans).'
            </label>
    ';
    }

    $html .=getErrors($errors, $name, $noview).'
        </div>
    </div>
    ';

    return $html;
}

function buttonAction($saveText='Save'){
    //$name, $trans, $errors, $edit=false, $childe=false, $cols=6,
    return '
    <div class="form-actions">
        <button type="button" class="btn btn-warning mr-1"
            onclick="history.back();">
            <i class="ft-x"></i> '.trans('main.Cancel').'
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="la la-check-square-o"></i> '.trans('main.'.$saveText).'
        </button>
    </div>
    ';

}

// function select($data){
//     //$name, $frkName, $rows, $trans, $errors, $edit=false, $childe=false, $cols=6, $required="required"

//     extract($data);
//     if(!isset($noview)) $noview = '';
//     if(!isset($edit)) $edit = false;
//     if(!isset($childe)) $childe = false;
//     if(!isset($parent)) $parent = false;
//     if(!isset($notrans)) $notrans = false;
//     if(!isset($label)) $label = false;
//     if(!isset($cols)) $cols = 6;
//     if(!isset($required)) $required = "";

//     $html = '
//     <div class="col-md-'.$cols.' '.$name.'">
//         ';
//         if(($rows && is_object($rows) && $rows->count() > 0) || is_array($rows)){
//      $html .= '<div class="form-group">';
//             if($label){
//              $html .=' <label for="'.$name.'">'.trans('main.'.$trans).'</label>';
//             }
//              $html .='  <select '.$required.' id="'.$name.'" class="form-control '.$name.'" name="'.$name.'">


//                 <option value="">'.trans('main.'.$trans).'</option>
//     ';      if(is_array($rows)){
//                 foreach ($rows as $row){
//                     $html .='<option value="'.$row.'"';

//                     if(($edit && $edit->$name == $row) || old($name) == $row){
//                         $html .='selected';
//                     }
//                     if(!$notrans)
//                         $html .= '>'.trans('main.'.$row) .'</option>';
//                     else
//                         $html .= '>'.$row.'</option>';
//                 }
//             }else{
//                 foreach ($rows as $row){
//                     $id = ($parent)? $row->parent->id : $row->id;
//                     if(($childe && $row->childe()) || !$childe){
//                         $html .='<option value="'.$id.'"';

//                         if(($edit && is_object($edit) && $edit->$name == $id) || (!is_object($edit) && $edit == $id) || old($name) == $id){
//                             // return $edit;
//                             $html .='selected';
//                         }
//                         $html .= '>'.getvalue($frkName, $row, $childe) .'</option>
//                         ';
//                     }
//                 }
//             }

//     $html .='
//             </select>
//     ';

//     $html .=getErrors($errors, $name, $noview).'
//         </div>';
//             }
//     $html .= '</div>
//     ';
//     return $html;
// }


// function langsSupport($edit, $childe=""){

//     $html = '
//     <div class="langsSupport">
//         <table class="table table-striped">
//             <tr>
//     ';
//                 foreach (get_langs() as $lang){
//                 $html .= '<th>
//                         <i class="flag-icon flag-icon-'.$lang->logo_abbr.'"></i>
//                     </th>';
//                 }
//     $html .= '</tr>

//             <tr>';

//                 foreach (get_langs() as $lang){
//                     $html .= '<td>';
//                     if(!$childe || ($childe && $edit->$childe->childe($lang->id) )){
//                         $html .= '  <a class="setttingUrl" hreflang="'. $lang->abbr .'"
//                             href="'. LaravelLocalization::getLocalizedURL($lang->abbr, null, [], true) .'">';

//                                 if($edit->childe($lang->id)){
//                                     $html .= '<i class="fas fa-edit delEdit';
//                                     if(($lang->id == $edit->childe_org()->lang_org)){
//                                         $html .= ' org_lang';
//                                     }
//                                     $html .= '" aria-hidden="true"></i>';
//                                 }else{
//                                     $html .= '<i class="fas fa-calendar-plus" aria-hidden="true"></i>';
//                                 }
//                             $html .= '</a>';
//                     }

//                     $html .= ' </td>';
//                 }
//         $html .= '</tr>
//         </table>
//     </div>
//     ';
//     return $html;
// }

// function getInt($value)
// {
//     if($value == 0 && $value !=null)
//         return '<i class="fas fa-times align-middle"></i>';
//     elseif($value)
//         return $value;
//     elseif ($value == null)
//         return trans('main.infinity');
// }

// function p_num($var)
// {
//     if($var != null && $var == 0)
//         return trans('main.zero');
//     else return $var;
// }

// function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
//     $output = NULL;
//     if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
//         $ip = $_SERVER["REMOTE_ADDR"];
//         if ($deep_detect) {
//             if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
//                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//             if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
//                 $ip = $_SERVER['HTTP_CLIENT_IP'];
//         }
//     }
//     $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
//     $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
//     $continents = array(
//         "AF" => "Africa",
//         "AN" => "Antarctica",
//         "AS" => "Asia",
//         "EU" => "Europe",
//         "OC" => "Australia (Oceania)",
//         "NA" => "North America",
//         "SA" => "South America"
//     );
//     if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
//         // if( ini_get('allow_url_fopen') ) {
//         //     die('allow_url_fopen is enabled. file_get_contents should work well');
//         // } else {
//         //     die('allow_url_fopen is disabled. file_get_contents would not work');
//         // }

//         // return file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
//         $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
//         // echo $ipdat . "<br>";
//         if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
//             switch ($purpose) {
//                 case "location":
//                     $output = array(
//                         "city"           => @$ipdat->geoplugin_city,
//                         "state"          => @$ipdat->geoplugin_regionName,
//                         "country"        => @$ipdat->geoplugin_countryName,
//                         "country_code"   => @$ipdat->geoplugin_countryCode,
//                         "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
//                         "continent_code" => @$ipdat->geoplugin_continentCode
//                     );
//                     break;
//                 case "address":
//                     $address = array($ipdat->geoplugin_countryName);
//                     if (@strlen($ipdat->geoplugin_regionName) >= 1)
//                         $address[] = $ipdat->geoplugin_regionName;
//                     if (@strlen($ipdat->geoplugin_city) >= 1)
//                         $address[] = $ipdat->geoplugin_city;
//                     $output = implode(", ", array_reverse($address));
//                     break;
//                 case "city":
//                     $output = @$ipdat->geoplugin_city;
//                     break;
//                 case "state":
//                     $output = @$ipdat->geoplugin_regionName;
//                     break;
//                 case "region":
//                     $output = @$ipdat->geoplugin_regionName;
//                     break;
//                 case "country":
//                     $output = @$ipdat->geoplugin_countryName;
//                     break;
//                 case "countrycode":
//                     $output = @$ipdat->geoplugin_countryCode;
//                     break;
//             }
//         } else return "no ipdat";
//     } else return "no";
//     return $output;
// }

// function admins($mails=false)
// {
//     $admins = App\User::where(['is_active'=> 1])->whereHas('role', function($q){
//         $q->where('admin', 1);
//     })->get();

//     if(!$mails) return $admins;

//     $emails = '';
//     foreach($admins as $admin){
//         $emails .= $admin->email . ',';
//     }

//     return rtrim($emails, ",");;
// }

// function advNotifyCreate($adv)
// {

//     $data = [
//         'noteType'=>'AdvNew',
//         'username'=>$adv->user->username,
//         'adv_id'=>$adv->id,
//     ];

//     Notify::create([
//         'id'=>User::generateRandomString(25),
//         'noteType'=>'advNew',
//         'type'=>'advNew',
//         'notifiable_type'=>'admin',
//         'notifiable_id'=>0,
//         'data'=> $data,
//     ]);
// }

// function sendAdvNotifyCreate($adv)
// {
//     advNotifyCreate($adv);
//     $users = admins();
//     \Notification::send($users, new AdvNew($adv));

//     event(new advCreateEvent($adv->id));
// }

// function adv_update($adv_id)
// {
//     $adv = Adv::findorFail($adv_id);
//     if($adv->status == 's2' ){
//         $adv->update(['status'=>'s1']);

//         if($adv->is_underreview()){
//             sendAdvNotifyCreate($adv);
//         }
//     }

// }

// function setCookies($name, $value, $minutes = 60, $responseName = 'Eadeldeen') {
//     Cookie::queue($name, $value, $minutes);
// }

// function setCookiess($name, $value, $minutes = 60, $responseName = 'Eadeldeen') {
//     // $response = new Response($responseName);
//     Request::cookie($name, $value, $minutes);
//     // cookie($name, $value, $minutes);
//     // return $response;
// }

// function getCookies($name) {
//     $value = Cookie::get($name);
//     return $value;
// }

// function getCookiess() {
//     $request = new Request;
//     $value = $request->cookie('defaultCountry');
//     return $value;
//  }

// function forgetCookies($name, $responseName = 'Eadeldeen') {
//     $cookie = Cookie::forget($name);
//     return response($responseName)->withCookie($cookie);
// }

// function countrylangs($city = false)
// {

//     $countrylangs = CountryLang::all_active();
//     $countrylang = $countrylangs->first();
//     $citylangs = null;
//     if($countrylang)
//         $citylangs = $countrylang->parent->citylangsActive();

//     return ($city)? $citylangs : $countrylangs;

// }


