@extends('adminlte::page')

@section('title', '新規投稿')

@section('content_header')
    <h1>新規投稿</h1>
@stop

@section('content')
 <!-- Main content -->
    <section class="content">
    @if($errors->any())
      <div class="alert alert-danger">
          入力内容に問題があります。もう一度確認して修正してください。
          <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
    @endif
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card">
              <!-- form start -->
              <form action="{{ route('memory.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card-body">                
                  <div class="form-group">
                    <label>日付</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                      <input type="text" 
                             class="form-control datetimepicker-input" 
                             name="recorded_date" 
                             value="{{ old('recorded_date') }}" 
                             data-target="#reservationdate" 
                             id="datepicker" />
                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label for="inputSentence">日記</label>
                    <input type="text" class="form-control" name="sentence" value="{{ old('sentence') }}" id="inputSentence" placeholder="50文字以内">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">画像(jpg)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image_file_path" id="imageUpload" accept="image/jpeg">
                        <label class="custom-file-label" for="imageUpload"></label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>プレビュー</label>
                    <img id="imagePreview" src="" alt="プレビュー画像" style="display: none; max-width: 50%; height: auto;">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{ route('memory.index') }}" class="btn btn-secondary">戻る</a>
                  <button type="submit" class="btn btn-primary">保存</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div> 
    </section>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.ja.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#datepicker').datepicker({
          language:'ja',
          format: 'yyyy/mm/dd',
          autoclose: true,
          todayHighlight: true
        });
      });
      
      // ファイルが選択されたときに実行されるイベント
      document.getElementById('imageUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];

        // 画像ファイルが選ばれたかチェックし、かつJPEG形式かチェック
        if (file && file.type === 'image/jpeg') {
          const reader = new FileReader();

          // ファイルが読み込まれたら、画像のプレビューを表示
          reader.onload = function(e) {
            const imgElement = document.getElementById('imagePreview');
            imgElement.src = e.target.result; // 読み込んだ画像をimgタグにセット
            imgElement.style.display = 'block'; // プレビュー画像を表示
          };

          // ファイルを読み込む
          reader.readAsDataURL(file);
        } else {
          // JPEG形式でない場合はプレビューを非表示に
          document.getElementById('imagePreview').style.display = 'none';

          // 警告メッセージを表示（任意）
          alert('JPG形式の画像を選択してください。');
        }
      });
    </script>
@stop