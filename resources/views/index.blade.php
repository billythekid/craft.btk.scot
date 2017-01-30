@extends('layouts.app')

@section('content')
    <div id="dl">
        <h2>Download Old Craft Versions</h2>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group {{ $errors->has('version') ? 'has-error' : '' }}">
                    <label for="version">Version</label>
                    <input id="version" name="version" class="form-control" type="text" placeholder="e.g 2.5" v-model="version">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group {{ $errors->has('build') ? 'has-error' : '' }}">
                    <label for="build">Build</label>
                    <input id="build" name="build" class="form-control" type="text" placeholder="Build" v-model="build">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <a class="form-control btn btn-primary" v-bind:href="dlHref"><i class="fa fa-cloud-download"></i> Download</a>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    var dl = new Vue({
        el: "#dl",
        data: {
            version: '',
            build: ''
        },
        computed: {
            dlHref: function () {
                return "http://download.buildwithcraft.com/craft/" +
                    this.version +
                    "/" +
                    this.version +
                    "." +
                    this.build +
                    "/Craft-" +
                    this.version +
                    "." +
                    this.build +
                    ".zip";
            }
        }
    });
</script>
@endpush