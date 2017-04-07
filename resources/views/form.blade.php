<div class="row-fluid">
    <div class="well">
        <form class="{{ $form->metadata->id }}" method="POST" action="{{ $form->metadata->publishedUrl }}">
            @if(preg_match('/medical/i', $form->metadata->title))
                <button class="btn btn-default copyAnswers pull-right">Copy Answers From Above</button>
            @endif
            <h3>{{ $form->metadata->title }}</h3>
            @foreach($form->items as $item)
                @if($item->type == "TEXT")
                    <label for="{{ $camper->id }}-{{ $item->id }}" class="control-label">
                        {{ preg_replace("/\{\{ campername \}\}/", $campername, $item->title) }}
                    </label>
                    <input id="{{ $camper->id }}-{{ $item->id }}" type="text"
                           name="entry.{{ $item->id }}"
                           class="form-control"
                           @if($item->isRequired == "true")
                           required
                            @endif
                    />
                @elseif($item->type == "PARAGRAPH_TEXT")
                    <label for="{{ $camper->id }}-{{ $item->id }}" class="control-label">
                        {{ preg_replace("/\{\{ campername \}\}/", $campername, $item->title) }}
                    </label>
                    <textarea id="{{ $camper->id }}-{{ $item->id }}" name="entry.{{ $item->id }}"
                              class="form-control"
                              @if($item->isRequired == "true")
                              required
                            @endif
                    ></textarea>
                @elseif($item->type == "CHECKBOX")
                    <div class="checkbox">
                        <label for="{{ $camper->id }}-{{ $item->id }}" class="control-label">
                            <input id="{{ $camper->id }}-{{ $item->id }}" type="checkbox"
                                   name="entry.{{ $item->id }}" value="{{ $item->choices[0] }}">
                            {{ preg_replace("/\{\{ campername \}\}/", $campername, $item->title) }}
                        </label>
                    </div>
                @elseif($item->type == "MULTIPLE_CHOICE")
                    <p>&nbsp;</p>
                    <label for="{{ $camper->id }}-{{ $item->id }}" class="control-label">
                        {{ preg_replace("/\{\{ campername \}\}/", $campername, $item->title) }}
                    </label>
                    <div class="btn-group" data-toggle="buttons">
                        @foreach($item->choices as $choice)
                            <label class="btn btn-default">
                                <input type="checkbox" name="entry.{{ $item->id }}" value="{{ $choice }}"
                                       autocomplete="off"/>
                                {{ $choice }}
                            </label>
                        @endforeach
                    </div>
                @elseif($item->type == "PAGE_BREAK")
                    <h4>{{ $item->title }}</h4>
                @endif
            @endforeach
            <p>&nbsp;</p>
            <div class="form-group">
                Please print this page and bring it with you to camp.
            </div>
        </form>
    </div>
</div>
