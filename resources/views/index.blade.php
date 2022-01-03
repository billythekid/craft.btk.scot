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

  <div id="sqlsrv">
    <h2>SQL Server to MySQL</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="sqlsrv">Paste the SQLSRV dump</label>
          <textarea class="form-control" id="sqlsrvcode" v-model="sqlsrvcode" rows="20"></textarea>
        </div>
      </div>
      <div class="col-md-6">
        <label for="mysql">Here's the MySQL:</label>
        <textarea id="mysql" class="form-control" readonly rows="20">@{{ mysqlcode }}</textarea>
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
          return "https://download.buildwithcraft.com/craft/" +
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
    var sqlsrv = new Vue({
      el: "#sqlsrv",
      data: {
        sqlsrvcode: ""
      },
      computed: {
        mysqlcode: function () {
          var workingcode = this.sqlsrvcode.replace(/\[dbo]\./gi, '');
          workingcode = workingcode.replace(/ N'/g, ' \'');
          workingcode = workingcode.replace(/int IDENTITY/gi, "int AUTO_INCREMENT");
          workingcode = workingcode.replace(/\[([a-zA-Z_0-9]*)]/gi, '$1');
          workingcode = workingcode.replace(/nvarchar\(MAX\)/gi, 'longtext');
          workingcode = workingcode.replace(/nvarchar\(([0-9]*)\)/gi, 'text($1)');
          workingcode = workingcode.replace(/smalldatetime/gi, 'timestamp');
          workingcode = workingcode.replace(/nchar/gi, 'text');
          workingcode = workingcode.replace(/.*--.*\n*/g, '');
          return workingcode;
        }
      }
    })
  </script>
@endpush
