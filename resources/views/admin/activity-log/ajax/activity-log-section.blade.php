@if($activityLog->event != 'login')
    @php
        
        if ($activityLog->subject !== null) {
            $activitySubject = json_decode($activityLog->subject);
        }
        else {
            if ($activityLog->event == 'created') {
                $activityProperties = $activityLog->changes;
                $activitySubject = $activityProperties['attributes'];
            }
            elseif ($activityLog->event == 'deleted') {
                $activityProperties = $activityLog->changes;
                $activitySubject = $activityProperties['old'];
            }
        }
        $activityAgentProps = json_decode($activityLog->properties);

    @endphp

    @if($activityLog->event != 'updated' || $activityLog->subject !== null)
        <div class="subject-block mb-5">
            <h4 class="pb-3">{{ __('Subject') }}</h4>
            <table class="table table-bordered table-sm table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Field') }}</th>
                        <th>{{ __('Value') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activitySubject as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>
                                @if(is_array($value))
                                    @foreach($value as $val)
                                        @if(!$loop->first) ,&nbsp; @endif {{ $val }}
                                    @endforeach
                                @elseif(is_object($value = json_decode($value)))
                                    @foreach($value as $key => $val)
                                        @if(is_array($val))
                                            {{ $key }} : @foreach($val as $v)
                                                @if(!$loop->first) ,&nbsp; @endif {{ $v }}
                                            @endforeach
                                        @else
                                            {{ $key }} : {{ $val }}<br>
                                        @endif
                                    @endforeach
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($activityLog->event == 'updated')
        @php
            $activityProperties = $activityLog->changes;
            $propertyKeys = array_keys($activityProperties['old']);
        @endphp
        <div class="acitivity-block">
            <h4 class="pb-3">{{ __('Log Properties') }}</h4>
            <table class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>{{ __('Field') }}</th>
                        <th>{{ __('Old') }}</th>
                        <th>{{ __('New') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propertyKeys as $key)
                        <tr>
                            <td>{{ $key }}</td>
                            <td class="old-data-{{ $key }}">
                                @if(is_array($activityProperties['old'][$key]))
                                    @foreach($activityProperties['old'][$key] as $val)
                                        @if(!$loop->first) ,&nbsp; @endif {{ $val }}
                                    @endforeach
                                @elseif(is_object($value = json_decode($activityProperties['old'][$key])))
                                    @foreach($value as $k => $val)
                                        @if(is_array($val))
                                            {{ $k }} : @foreach($val as $v)
                                                @if(!$loop->first) ,&nbsp; @endif {{ $v }}
                                            @endforeach
                                        @else
                                            {{ $k }} : {{ $val }}<br>
                                        @endif
                                    @endforeach
                                @else
                                    {{ $activityProperties['old'][$key] }}
                                @endif
                            </td>
                            <td class="new-data-{{ $key }}">
                                @if(is_array($activityProperties['attributes'][$key]))
                                    @foreach($activityProperties['attributes'][$key] as $val)
                                        @if(!$loop->first) ,&nbsp; @endif {{ $val }}
                                    @endforeach
                                @elseif(is_object($value = json_decode($activityProperties['attributes'][$key])))
                                    @foreach($value as $k => $val)
                                        @if(is_array($val))
                                            {{ $k }} : @foreach($val as $v)
                                                @if(!$loop->first) ,&nbsp; @endif {{ $v }}
                                            @endforeach
                                        @else
                                            {{ $k }} : {{ $val }}<br>
                                        @endif
                                    @endforeach
                                @else
                                    {{ $activityProperties['attributes'][$key] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@else
    @php
        $activitySubject = json_decode($activityLog->properties);
    @endphp
    <div class="subject-block mb-5">
        <h4 class="pb-3">{{ __('Subject') }}</h4>
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>{{ __('Field') }}</th>
                    <th>{{ __('Value') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activitySubject as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>
                            @if(is_array($value))
                                @foreach($value as $val)
                                    @if(!$loop->first) ,&nbsp; @endif {{ $val }}
                                @endforeach
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@if($activityAgentProps && $activityAgentProps->agent)
    <div class="subject-block mb-5">
        <h4 class="pb-3">{{ __('Extra Properties') }}</h4>
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>{{ __('Field') }}</th>
                    <th>{{ __('Value') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activityAgentProps->agent as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>
                            {{ $value }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif