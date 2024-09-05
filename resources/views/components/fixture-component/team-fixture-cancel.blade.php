<div style="width: 100%;margin-top: 10px;">
    @foreach($teams as $team)
        <div style="display: flex;flex-direction: row;align-items: center;width: auto;padding: 8px 0;">
            <div style="width: 24px;height: 24px;padding-right: 8px;">
                <img src="{{$team['logo']}}" style="width: 100%;">
            </div>
            <p style="color: #000000;font-family: Chakra Petch, Helvetica, sans-serif;font-size: 16px;font-style: normal;font-weight: 400;margin: 0;">{{ $team['name'] }}</p>
        </div>
    @endforeach
</div>
