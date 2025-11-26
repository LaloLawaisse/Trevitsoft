<div class="modal-dialog" role="document">
    <div class="modal-content rounded-lg shadow-xl overflow-hidden">
        {{-- Modal Header --}}
        <div class="modal-header flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h4 class="text-lg font-semibold text-gray-900">
                {{ $campaign->name }}
            </h4>
            <button type="button" class="text-gray-400 hover:text-gray-600 text-xl" data-dismiss="modal" aria-label="Close">
                &times;
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body p-6 space-y-5 text-sm text-gray-800">
            {{-- Type & Sent On --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <strong>@lang('crm::lang.campaign_type'):</strong>
                    @if($campaign->campaign_type == "sms")
                        {{ __("crm::lang.sms") }}
                    @elseif($campaign->campaign_type == "email")
                        {{ __("business.email") }}
                    @endif
                </div>
                @if(!empty($campaign->sent_on))
                    <div class="text-right">
                        <strong>@lang('crm::lang.sent_on'):</strong>
                        {{ @format_datetime($campaign->sent_on) }}
                    </div>
                @endif
            </div>

            {{-- Email fields --}}
            @if($campaign->campaign_type == 'email')
                <div>
                    <strong>@lang('crm::lang.subject'):</strong>
                    <p class="mt-1">{{ $campaign->subject }}</p>
                </div>
                <div>
                    <strong>@lang('crm::lang.email_body'):</strong>
                    <div class="prose max-w-none mt-1">{!! $campaign->email_body !!}</div>
                </div>
            @elseif($campaign->campaign_type == 'sms')
                <div>
                    <strong>@lang('crm::lang.sms_body'):</strong>
                    <p class="mt-1">{!! $campaign->sms_body !!}</p>
                </div>
            @endif

            {{-- Transaction Activity --}}
            @if(!empty($campaign->additional_info['to']) && $campaign->additional_info['to'] == 'transaction_activity')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <strong>@lang('crm::lang.transaction_activity'):</strong>
                        @lang('crm::lang.' . $campaign->additional_info['trans_activity'])
                    </div>
                    <div>
                        <strong>@lang('crm::lang.in_days'):</strong>
                        {{ $campaign->additional_info['in_days'] }}
                    </div>
                </div>
            @endif

            {{-- Contact list --}}
            @php
                $leads = [];
                $customers = [];
            @endphp

            @if(count($notifiable_users) > 0)
                @foreach($notifiable_users as $contact)
                    @php
                        if ($contact->type == 'lead') $leads[] = $contact->name;
                        elseif ($contact->type == 'customer') $customers[] = $contact->name;
                    @endphp
                @endforeach
            @endif

            @if(!empty($customers))
                <div>
                    <strong>@lang('lang_v1.customers'):</strong>
                    <p class="mt-1 text-gray-700">{{ implode(', ', $customers) }}</p>
                </div>
            @endif

            @if(!empty($leads))
                <div>
                    <strong>@lang('crm::lang.leads'):</strong>
                    <p class="mt-1 text-gray-700">{{ implode(', ', $leads) }}</p>
                </div>
            @endif
        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 text-sm text-gray-600">
            <div class="flex items-center gap-2">
                <i class="fas fa-pencil-alt text-gray-400"></i>
                <span>
                    @lang('crm::lang.created_this_campaign_on', ['name' => $campaign->createdBy->user_full_name])
                    {{ @format_date($campaign->created_at) }}
                </span>
            </div>
            <button type="button" class="bg-gray-700 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded" data-dismiss="modal">
                @lang('messages.close')
            </button>
        </div>
    </div>
</div>
