@extends('layouts.main')
@section('title', 'Ver Formularios')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Ver Formularios') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('forms.index'), __('Formularios'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Ver Formularios') }}</li>
        </ul>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="section-body">
            <div class="row">
              
                <div class="card col-md-6 mx-auto" style="padding:0px;">
                    <div class="card-header" id="hedd">
                        <div class="logo-from-wrapper">
                        <img src="https://dea.wearesmart.co/images/logo_nav_footer.png" width="25%" height="auto"/><br>
                        </div>
                        <h5>  <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            {{ $formValue->Form->title }}
                        </h5>
                    </div>
                    

                 
                    <div class="card-body" id="contenido">
                        <div class="view-form-data">
                            <div class="row">
                                @foreach ($array as $keys => $rows)
                                    @foreach ($rows as $row_key => $row)
                                        @php
                                            // $fieldHidden = false;
                                            // if (in_array($row->name, $hideFields)) {
                                            //     $fieldHidden = true;
                                            // }
                                            if (!isset($row->label)) {
                                                        $row->label = '';
                                                    }
                                        @endphp
                                        @if ($row->type == 'checkbox-group')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                        <ul>
                                                            @foreach ($row->values as $key => $options)
                                                                @if (isset($options->selected))
                                                                    <li>
                                                                        <label>{{ $options->label }}</label>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'file')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                            @if (property_exists($row, 'value'))
                                                                @if ($row->value)
                                                                    @php
                                                                        $allowed_extensions = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox', 'xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                                                    @endphp
                                                                    @if ($row->multiple)
                                                                        <div class="row">
                                                                            @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                                                                                @foreach ($row->value as $img)
                                                                                    <div class="col-6">
                                                                                        @php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                            @php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="{{ asset('storage/app/' . $img) }}"
                                                                                                type="image"
                                                                                                download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                        @else
                                                                                            <img src="{{ Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                                class="mb-2 img-responsive img-thumbnail">
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                @foreach ($row->value as $img)
                                                                                    <div class="col-6">
                                                                                        @php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                            @php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="{{ Storage::url($img) }}"
                                                                                                type="image"
                                                                                                download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                        @else
                                                                                            <img src="{{ Storage::url($img) }}"
                                                                                                class="mb-2 img-responsive img-thumbnail">
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                @if ($row->subtype == 'fineuploader')
                                                                                    @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                                                                                        @if ($row->value[0])
                                                                                            @foreach ($row->value as $img)
                                                                                                @php
                                                                                                    $fileName = explode('/', $img);
                                                                                                    $fileName = end($fileName);
                                                                                                @endphp
                                                                                                @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                                    <a class="my-2 btn btn-info"
                                                                                                        href="{{ asset('storage/app/' . $img) }}"
                                                                                                        type="image"
                                                                                                        download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                                @else
                                                                                                    <img src="{{ Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                                        class="mb-2 img-responsive img-thumbnail">
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($row->value[0])
                                                                                            @foreach ($row->value as $img)
                                                                                                @php
                                                                                                    $fileName = explode('/', $img);
                                                                                                    $fileName = end($fileName);
                                                                                                @endphp
                                                                                                @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                                    <a class="my-2 btn btn-info"
                                                                                                        href="{{ Storage::url($img) }}"
                                                                                                        type="image"
                                                                                                        download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                                @else
                                                                                                    <img src="{{ Storage::url($img) }}"
                                                                                                        class="mb-2 img-responsive img-thumbnail">
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endif
                                                                                @else
                                                                                    @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                                                                                        @if (in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                            @php
                                                                                                $fileName = explode('/', $row->value);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="{{ asset('storage/app/' . $row->value) }}"
                                                                                                type="image"
                                                                                                download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                        @else
                                                                                            <img src="{{ Storage::exists($row->value) ? asset('storage/app/' . $row->value) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                                class="mb-2 img-responsive img-thumbnailss">
                                                                                        @endif
                                                                                    @else
                                                                                        @if (in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                            @php
                                                                                                $fileName = explode('/', $row->value);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="{{ Storage::url($row->value) }}"
                                                                                                type="image"
                                                                                                download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                        @else
                                                                                            <img src="{{ Storage::url($row->value) }}"
                                                                                                class="mb-2 img-responsive img-thumbnailss">
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'header')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        @if (isset($row->className) && $row->className != "direccion-title")
                                                        <!-- {{ $row->className }} -->
                                                        <!-- <{{ $row->subtype }}> -->
                                                            {!! html_entity_decode($row->label) !!}
                                                            <!-- </{{ $row->subtype }}> -->
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'paragraph')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">


                                                        
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'radio-group')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                            @foreach ($row->values as $key => $options)
                                                                @if (isset($options->selected))
                                                                    {{ $options->label }}
                                                                @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'select')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif

                                                        <p>
                                                            @foreach ($row->values as $options)
                                                                @if (isset($options->selected))
                                                                    {{ $options->label }}
                                                                @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif ($row->type == 'autocomplete')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                            {{ $row->value }}
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'number')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <b>{{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                    </b>
                                                    <p>
                                                        {{ isset($row->value) ? $row->value : '' }}
                                                    </p>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'text')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if ($row->subtype == 'color')
                                                            <div class="p-2"
                                                                style="background-color: {{ $row->value }};">
                                                            </div>
                                                        @else
                                                            <p>
                                                             {!! html_entity_decode($row->value) !!}

                                                                <!-- {{ isset($row->value) ? $row->value : '' }} -->
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'date')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                            {{ isset($row->value) ? date('d-m-Y', strtotime($row->value)) : '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'textarea')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if ($row->subtype == 'ckeditor')
                                                            {!! isset($row->value) ? $row->value : '' !!}
                                                        @else
                                                            <p>
                                                                {{ isset($row->value) ? $row->value : '' }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'starRating')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        @php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                            }
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                        @endphp
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <p>
                                                        <div id="{{ $row->name }}" class="starRating"
                                                            data-value="{{ $value }}"
                                                            data-no_of_star="{{ $noOfStar }}">
                                                        </div>
                                                        <input type="hidden" name="{{ $row->name }}"
                                                            value="{{ $value }}">
                                                        </p>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'SignaturePad')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        @php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                            }
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                        @endphp
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (property_exists($row, 'value'))
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <img id="silas" src="{{ asset(Storage::url($row->value)) }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'break')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <hr class="hr_border">
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'location')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {!! Form::label('location_id', 'Location:') !!}
                                                        <iframe width="100%" height="260" frameborder="0"
                                                            scrolling="no" marginheight="0" marginwidth="0"
                                                            src="https://maps.google.com/maps?q={{ $row->value }}&hl=en&z=14&amp;output=embed">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'video')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                        <a href="{{ route('selfie.image.download', $formValue->id) }}">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton">{{ __('Download Video') }}</button></a>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @elseif($row->type == 'selfie')
                                            {{-- @if (!$fieldHidden) --}}
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                        <img
                                                            src=" {{ Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png') }}"class="img-responsive img-thumbnailss mb-2">
                                                        <br>
                                                        <a href="{{ route('selfie.image.download', $formValue->id) }}">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton">{{ __('Download Image') }}</button></a>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @else
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, isset($row->label)) }}@if (isset($row->required))
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        {{ isset($row->value) ? $row->value : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:javascript:history.go(-1)"
                            class="btn btn-secondary float-end">{{ __('Volver') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var noOfStar = $(this).attr('data-no_of_star');
                if (noOfStar == 10) {
                    val = val / 2;
                }
                $(this).rateYo({
                    rating: val,
                    readOnly: true,
                    numStars: noOfStar
                })
            });
        }
    </script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
crossorigin="anonymous"
referrerpolicy="no-referrer"
></script>


<script src="https://raw.githubusercontent.com/parallax/jsPDF/master/src/modules/png_support.js"></script>

    <script>

        $(document).ready(function(){

            var doc = new jsPDF();          
            var elementHandler = {
              '#silas': function (element, renderer) {
                alert("")
                return true;
              }
            };

            

            var source = window.document.getElementById("contenido");
            doc.fromHTML(
                source,
                15,
                15,
                {
                  'width': 180,'elementHandlers': elementHandler
                });


            console.log($("img"))


        });
    </script>

    <script>
  document.addEventListener("DOMContentLoaded", function() {
    var divToHide = document.querySelector(".col-12 label[for='arrivedBy']").parentNode;
    if (divToHide) {
      divToHide.style.display = "none";
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    var divToHide2 = document.querySelector(".col-12 label[for='createdBy']").parentNode;
    if (divToHide2) {
      divToHide2.style.display = "none";
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    var divToHide3 = document.querySelector(".col-12 label[for='confirmation']").parentNode;
    if (divToHide3) {
      divToHide3.style.display = "none";
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    var divToHide4 = document.querySelector(".col-12 label[for='button-1703767927522-0']").parentNode;
    if (divToHide4) {
      divToHide4.style.display = "none";
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    var divToHide5 = document.querySelector(".col-12 label[for='address']").parentNode;
    if (divToHide5) {
      divToHide5.style.display = "none";
    }
  });
    </script>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la URL actual del navegador
        const currentUrl = window.location.href;
    
        // URL que deseas detectar
        const targetUrl = 'https://dea.wearesmart.co/form-values/18/view'; // Cambia esto por la URL que quieras detectar
    
        // Función para aplicar el estilo
        function applyStyle() {
            const styleElement = document.createElement('style');
            styleElement.textContent = `
                #forms-table > thead > tr > th:nth-child(4) {

        max-width: 24% !important;
}
            `;
            document.head.appendChild(styleElement);
        }
    
        // Verificar si la URL actual coincide con la URL objetivo
        if (currentUrl === targetUrl) {
            applyStyle();
        }
    });
    </script>
 -->

 <style> .logo-from-wrapper{
    text-align: center;
    background: #3366cc;
    padding: 1em;
    margin-top: 0em;
}</style>
@endpush
