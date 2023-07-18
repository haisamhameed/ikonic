<div class="my-2 shadow  text-white bg-dark p-1" id="suggestion_content">
  @forelse ($users as $user)
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $user->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $user->email }}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <button id="create_request_btn_{{ $user->id }}" class="btn btn-primary me-1" onclick="sendRequest('{{ $user->id }}')" >Connect</button>
    </div>
  </div>
  @empty
    
  @endforelse
</div>
@if($loadMorePage==1)
  <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
    <button class="btn btn-primary"  data-page="2" onclick="getMoreSuggestions()" id="load_more_btn">Load more</button>
  </div>
@endif
