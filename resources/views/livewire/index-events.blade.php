<div>
    <div class="flex">
        <div class="ltr:mr-4 rtl:ml-4">
            <img src="{{ Avatar::create(auth('volunteer')->user()->branch->email)->toBase64() }}" alt="image" class="w-14 h-14 rounded" />
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-lg mb-2 text-primary">{{ auth('volunteer')->user()->email }}</h4>
            <p class="media-text mb-5">{{ $event->reason }}</p>

            <div id="commentsList">
                @if (count($event->comments) > 0)
                    @foreach ($comments as $comment)
                        <div class="flex mb-5 max-h-40" wire:poll.10s >
                            <div class="ltr:mr-4 rtl:ml-4">
                                <img src="{{ Avatar::create($comment->authorable->email)->toBase64() }}" alt="image" class="w-14 h-14 rounded" />
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-lg mb-2 text-primary">{{ $comment->authorable->name ?? 'Unknown Author'}}</h4>
                                <p class="media-text">{{ $comment->body }}</p>
                               
                                <div class="whitespace-nowrap text-white-dark mt-2">{{ $comment->created_at->diffForHumans() }}</div>
                                
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="mt-5 w-full items-center space-x-3 rtl:space-x-reverse sm:flex">
        <div class="relative flex-1">
            <input type="text" id="commentInput" placeholder="اكتب تعليقك ..." wire:model="comment" class="form-input rounded-full shadow-[0_0_4px_2px_rgb(31_45_61_/_10%)] bg-white h-11 placeholder:tracking-wider" />
            <button wire:click="submit" class="btn btn-primary rounded-full absolute ltr:right-1 rtl:left-1 inset-y-0 m-auto w-9 h-9 p-0 flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                    <path d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z" stroke="currentColor" stroke-width="1.5"></path>
                    <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
