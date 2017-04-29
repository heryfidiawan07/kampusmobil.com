<a href="#" type="button" class="" data-toggle="modal" data-target="#forumModal">
    Forum Kategori
</a>
<!-- Modal -->
<div class="modal right fade" id="forumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&#60; close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: white;">Kategori Forum</h4>
      </div>

      <div class="modal-body">
        <table class="table" id="modal-table">
          @foreach($brands as $brand)
            <tr><td>
              <a href="/forum/{{$brand->slug}}" style="display: block; color: black;">{{$brand->brand}}</a>
            </td></tr>
          @endforeach
        </table>
      </div>

    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
