<div style="border-radius: 4px 4px 16px 4px;border: 1px solid #EFEEEE;width: 100%;margin-bottom: 10px;">
    @foreach($teams as $key => $team)
        <div style="display: block;width: auto;padding: 8px;@if($loop->last)border-top: 1px solid #EFEEEE;@endif">
            <div style="display: inline-block;width: 32px;height: 32px;padding-right: 15px;">
                <img src="{{$team['logo']}}" style="width: 100%;">
            </div>
            <p style="display: inline-block;position:relative;top:-10px;color: #000000;font-family: 'Chakra Petch', Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">{{ $team['name'] }}</p>
        </div>
    @endforeach
</div>
