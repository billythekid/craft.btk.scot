@extends('layouts.app')

@section('content')
  <div id="dl">
    <h2>Download Old Craft Versions</h2>
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group {{ $errors->has('version') ? 'has-error' : '' }}">
          <label for="version">Version</label>
          <input id="version" name="version" class="form-control" type="text" placeholder="e.g 2.6" v-model="version">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group {{ $errors->has('build') ? 'has-error' : '' }}">
          <label for="build">Build</label>
          <input id="build" name="build" class="form-control" type="text" placeholder="e.g 2986" v-model="build">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label> </label>
          <a class="form-control btn btn-primary" v-bind:href="dlHref"><i class="fa fa-cloud-download"></i> Download</a>
        </div>
      </div>
    </div>

  </div>

  <div id="awscode">
    <h2>Access Policy Generator</h2>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group ">
          <label for="bucket">AWS Bucket Name</label>
          <input id="bucket" name="bucket" class="form-control" type="text" placeholder="AWS Bucket Name" v-model="bucket">
        </div>
      </div>
      <div class="col-md-8">
        <p>Copy this code:</p>
        <pre>{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": "s3:ListAllMyBuckets",
      "Resource": "arn:aws:s3:::*"
    },
    {
      "Effect": "Allow",
      "Action": [
        "s3:ListBucket",
        "s3:ListBucketMultipartUploads",
        "s3:GetBucketLocation"
      ],
      "Resource": "arn:aws:s3:::@{{ bucket }}"
    },
    {
      "Effect": "Allow",
      "Action": [
        "s3:AbortMultipartUpload",
        "s3:DeleteObject",
        "s3:GetObjectAcl",
        "s3:GetObject",
        "s3:PutObjectAcl",
        "s3:PutObject"
      ],
      "Resource": "arn:aws:s3:::@{{ bucket }}/*"
    }
  ]
}</pre>
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
    var aws = new Vue({
      el: '#awscode',
      data: {
        bucket: ''
      }
    });
  </script>
@endpush
