<div class="my-2 shadow text-white bg-dark p-1" id="">
  @forelse ($receiveRequest as $request)
    <div class="d-flex justify-content-between">
      <table class="ms-1">
        <td class="align-middle">{{ $request->userSender->name }}</td>
        <td class="align-middle"> - </td>
        <td class="align-middle">{{ $request->userSender->email }}</td>
        <td class="align-middle">
      </table>
      <div>
        @if ($request->status == 0 && $request->sender_id==auth()->user()->id)
          <button id="cancel_request_btn_" class="btn btn-danger me-1"
            onclick="deleteRequest('{{ $request->id }}')">Withdraw Request</button>
        @elseif($request->status == 0 && $request->receiver_id==auth()->user()->id)
          <button id="accept_request_btn_" class="btn btn-primary me-1"
            onclick="acceptRequest('{{ $request->id }}')">Accept</button>
        @endif
      </div>
    </div>
  @empty
    
  @endforelse
</div>
