@extends('layouts.theme')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">

            <div class="col-md-8">
                @include('admin.flash_msg')
                <div class="card">
                    <div class="card-header">Write a Review</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('post_review') }}" id="review_post">
                            @csrf
                            <input type="hidden" name="employer_id" value="{{ $employer->id }}"/>
                            <input type="hidden" name="rating_value" id="rating_value" value="0"/>
                            
                            <div class="form-group row">
                                <label for="company" class="col-md-4 col-form-label text-md-right">Rating <span
                                            class="mendatory-mark">*</span>
                                </label>
                                <div class="col-md-6">

                                    <div class="rate">
                                        <input type="radio" id="star5" class="star" name="rate" value="5"/>
                                        <label for="star5" title="five">5 stars</label>
                                        <input type="radio" class="star" id="star4" name="rate" value="4"/>
                                        <label for="star4" title="four">4 stars</label>
                                        <input type="radio" class="star" id="star3" name="rate" value="3"/>
                                        <label for="star3" title="three">3 stars</label>
                                        <input type="radio" class="star" id="star2" name="rate" value="2"/>
                                        <label for="star2" title="two">2 stars</label>
                                        <input type="radio" class="star" id="star1" name="rate" value="1" required/>
                                        <label for="star1" title="one">1 star</label>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Your Review <span
                                            class="mendatory-mark">*</span>
                                </label>
                                <div class="col-md-6">
                                    <textarea name="comments" id="comments" rows="5" class="form-control mb-2"
                                              onkeydown="limitText(this.form.comments,this.form.countdown,140);"
                                              onkeyup='limitText(this.form.comments,this.form.countdown,140);'></textarea>

                                    You have
                                    <input readonly type="text" name="countdown" size="3" value="140"> chars left


                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-gray"><i class="la la-times"></i> Cancel
                                    </button>
                                    <button type="button" class="btn btn-success btn_submit"><i class="la la-save"></i>
                                        Upload
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-js')

    <script type="text/javascript">
      function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
          limitField.value = limitField.value.substring(0, limitNum);
        } else {
          limitCount.value = limitNum - limitField.value.length;
        }
      }
    </script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script type="text/javascript">

      $(document).on('click', '.star', function () {
        $('#rating_value').val($(this).val())
      });


      $(document).on('click', '.btn_submit', function () {

        var star_rating = $('#rating_value').val();
        var comments = $('#comments').val();
        var status = 1;

        if (star_rating == 0) {
          alert('please select your rating');
          status = 0;
          return false;
        }

        if (comments.length == '') {
          alert('Please enter your review');
          status = 0;
          return false;
        } else if (comments.length > 140) {
          alert('Only allowed 140 characters');
          status = 0;
          return false;
        }
        else {
          $('#review_post').submit();
        }


      });


    </script>

@endsection