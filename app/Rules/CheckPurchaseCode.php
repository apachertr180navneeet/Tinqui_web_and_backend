<?php
namespace App\Rules; use App\Config\ps_constant; use Illuminate\Contracts\Validation\InvokableRule; use Illuminate\Support\Facades\Http; class CheckPurchaseCode implements InvokableRule { public function __invoke($attribute, $value, $fail) { goto QYK3B; AgSZS: $tokenType = config("\141\160\x70\56\x65\x6e\x76\141\x74\x6f\x5f\x74\157\153\145\x6e\x5f\x74\171\160\x65"); goto VHeuq; QYK3B: if (config("\141\x70\160\x2e\x64\145\x76\145\154\x6f\160\x6d\x65\156\164")) { goto DS9KR; } goto AgSZS; rPaa9: $response = json_decode(Http::withHeaders(["\141\x75\x74\150\x6f\162\151\172\x61\x74\x69\157\x6e" => $tokenType . "\40" . $token])->get(ps_constant::ApiUrl . ps_constant::ApiVersion . "\57\x6d\x61\162\153\145\164\x2f\141\165\x74\150\x6f\162\57\x73\141\x6c\145\x3f\143\157\144\145\75" . $purchaseCode)); goto hRLHz; Bqu2y: E3H3O: goto lrr1c; lrr1c: DS9KR: goto lU82f; PRBa8: $purchaseCode = $value; goto rPaa9; VHeuq: $token = config("\141\160\160\x2e\145\156\166\x61\x74\x6f\x5f\x74\157\x6b\x65\x6e"); goto PRBa8; hRLHz: if (!empty($response->item)) { goto E3H3O; } goto bgVfY; bgVfY: $fail(__("\151\x6e\x76\141\154\151\x64\137\x70\x75\x72\x63\150\141\163\x65\x5f\x63\x6f\x64\x65")); goto Bqu2y; lU82f: } }
