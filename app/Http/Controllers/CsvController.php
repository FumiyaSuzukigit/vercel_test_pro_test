<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CsvRequest;
use Illuminate\Support\Facades\Validator;
use App\Rules\UniqueNameInShopsRule;

class CsvController extends Controller
{
    public function upload(CsvRequest $request) {

    $uploaded_file = $request->file('csvdata');
    $orgName = date('YmdHis') ."_".$request->file('csvdata')->getClientOriginalName();
    $spath = storage_path('app/');
    $path = $spath.$request->file('csvdata')->storeAs('',$orgName);

    $file_content = file_get_contents($path);
    $encoding = mb_detect_encoding($file_content, 'UTF-8, SJIS-win', true);

    if ($encoding !== 'UTF-8' && $encoding !== 'SJIS-win') {
        Storage::delete($orgName);
        return redirect(route('managementIndex'))->with('error', '無効な文字コードです。');
    }

    if ($encoding !== 'UTF-8') {
        $converted_file = $spath . "converted_" . $orgName;
        $this->convertFileEncode($path, 'sjis-win', $converted_file, 'UTF-8', "\r\n");
        $path = $converted_file;
    }

    $result = (new FastExcel)->configureCsv(',')->importSheets($path);

    $dataForValidation = [];
    foreach ($result->first() as $item) {
        $dataForValidation[] = [
            'name' => $item['name'],
            'area' => $item['area'],
            'category' => $item['category'],
            'overview' => $item['overview'],
            'url' => $item['url'],
        ];
    }

    $rules = [
        '*.name' => ['required', 'string', 'max:50', new UniqueNameInShopsRule],
        '*.area' => 'required|string|in:東京都,大阪府,福岡県',
        '*.category' => 'required|string|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
        '*.overview' => 'required|string|max:400',
        '*.url' => 'required|string|url|image_mime|max:5120',
    ];

    $customMessages = [
    '*.name.required' => '店舗名は必須項目です。',
    '*.name.string' => '店舗名は文字列で入力してください。',
    '*.name.max' => '店舗名は50文字以内で入力してください。',
    '*.name.unique_name_in_shops' => 'この店舗名は既に存在します。',
    '*.area.required' => 'エリアは必須項目です。',
    '*.area.string' => 'エリアは文字列で入力してください。',
    '*.area.in' => 'エリアは東京都、大阪府、福岡県のいずれかを選択してください。',
    '*.category.required' => 'カテゴリは必須項目です。',
    '*.category.string' => 'カテゴリは文字列で入力してください。',
    '*.category.in' => 'カテゴリは寿司、焼肉、イタリアン、居酒屋、ラーメンのいずれかを選択してください。',
    '*.overview.required' => '概要は必須項目です。',
    '*.overview.string' => '概要は文字列で入力してください。',
    '*.overview.max' => '概要は400文字以内で入力してください。',
    '*.url.required' => 'URLは必須項目です。',
    '*.url.string' => 'URLは文字列で入力してください。',
    '*.url.url' => '有効なURLを入力してください。',
    '*.url.image_mime' => '画像はjpg・jpeg・pngである必要があります。',
    '*.url.max' => '画像のサイズは5MB以下である必要があります。',
    ];

        $validator = Validator::make($dataForValidation, $rules,$customMessages);

        $validator->after(function ($validator) use ($dataForValidation) {
        foreach ($validator->errors()->messages() as $key => $messages) {
            list($line_num, $item_name) = explode('.', $key);
            $line_num = $line_num + 1;
            $item_name_ja = [
                'name' => '店舗名',
                'area' => 'エリア',
                'category' => 'カテゴリ',
                'overview' => '概要',
                'url' => 'URL',
            ][$item_name];
            foreach ($messages as $index => $message) {
                $validator->errors()->forget($key);
                $validator->errors()->add($key, "CSVファイルの{$line_num}行目の{$item_name_ja}にエラーがあります。{$message}");
            }
        }
        });

        if ($validator->fails()) {
                $errors = $validator->errors();
                Storage::delete($orgName);
                Storage::delete("converted_" . $orgName);
                return redirect(route('managementIndex'))->withErrors($errors);
            }

    $count = 0;
    foreach ($result as $row) {
    foreach($row as $item){
            $imageUrl = $item["url"];
            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
            $contents = file_get_contents($imageUrl);
            $imageName = Str::random(10) . '.' . $extension;
            Storage::put('public/shop_photo/'.$imageName, $contents);
            $imagePath = 'storage/shop_photo/' . $imageName;
    $param = [
    'name' => $item["name"],
    'area' => $item["area"],
    'category' => $item["category"],
    'overview' => $item["overview"],
    'image_name' => $imageName,
    'path' => $imagePath,
    'created_at' => now(),
    ];
    DB::table('shops')->insert($param);
    $count++;
    }}

    Storage::delete($orgName);
    Storage::delete("converted_" . $orgName);

    return redirect(route('managementIndex',['count' => $count]));
    }



    protected function convertFileEncode($infname="", $incode='sjis-win', $outfname="", $outcode='UTF-8', $nl="\r\n") {
        if ( ! is_file($infname) ) {
            die("変換失敗：{$infname} が見つかりません．");
        }
        $tmp_filename = getmypid().'.tmp';
        $outfp = fopen($tmp_filename, 'wb');
        if ($outfp === FALSE) {
            die("変換失敗：{$tmp_filename} に書き込むことができません．");
        }
        $fp = fopen($infname,'r') or die("ファイル({$infname})のオープンに失敗しました");
        while ( ($line = fgets($fp,999999)) !== false ) {
            $outstr = mb_convert_encoding($line, $outcode, $incode);
            $outstr = preg_replace("/\r\n|\r|\n/", $nl, $outstr);
            fwrite($outfp, $outstr);
        }
        fclose($fp);
        fclose($outfp);
        rename($tmp_filename, $outfname);
        chmod($outfname, 0666);
        return true;
    }
}
