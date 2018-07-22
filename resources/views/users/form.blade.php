
 <div class="form-row">
    <div class="col">
        <div class="form-group {{ $errors->has('role_list') ? ' has-danger' : '' }}">
                <label class="form-control-label">Role</label>
                {!! Form::select('role_list', $roles, null, ['placeholder' => 'Select Role', 'class' => 'form-control'] ) !!}
                @if ($errors->has('role_list'))
                    <div class="invalid-feedback">{{ $errors->first('role_list') }}</div>
                @endif
        </div>
    </div>
</div>

 <div class="form-row">
    <div class="col">
        <div class="form-group {{ $errors->has('company_list') ? ' has-danger' : '' }}">
                <label class="form-control-label">Company</label>
                {!! Form::select('company_list', $companies, null, ['placeholder' => 'Select Companies', 'class' => 'form-control'] ) !!}
                @if ($errors->has('company_list'))
                    <div class="invalid-feedback">{{ $errors->first('company_list') }}</div>
                @endif
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <lable class="form-control-label">Name</lable>
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <lable class="form-control-label">Email</lable>
            {{ Form::text('email', null, ['type' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter Email']) }}
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
            <label>Password</label>
            <input id="password" type="password" class="form-control" placeholder="Enter Password" name="password">
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
        </div>
    </div>

     <div class="col">
        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
            <label>Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                @endif
        </div>
    </div>
</div>

<div class="form-row mt-3">
    <div class="col">
        <button class="btn btn-secondary btn-block p-3" type="submit">Submit</button>
    </div>
</div>