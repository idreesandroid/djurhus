<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
 <div class="comments-box">
      <div class="comments-box-header">
         <div class="row">
            <div class="col col-text">
               <h5>Reviews</h5>
               <br>
               <p>
                  <b>Rating Snapshot</b>
                  <br>
                  Select a row below to filter reviews
               </p>
            </div>
            <div class="col-lg-12">
               <!--<p>Select a row below to filter reviews</p>-->
<?php
               ob_start();
wp_list_comments(apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ));
$variable = ob_get_clean();
        //var_dump(strip_tags($variable));
//$allComments = str_split(strip_tags($variable));
$variable = preg_replace("/[\r\n]+/", "\n", $variable);
$variable = preg_replace("/\s+/", ' ', $variable);
$allComments = str_split(str_replace(' ', '', strip_tags($variable)));

$counts = array_count_values($allComments);



//print_r($counts[5]);

?>
               <div class="filter-star-rating">
                  <div class="star-rating-box">
                     <ul class="star-rating-list">
                        <li>
                           <span>
                           5
                           <i class="fas fa-star"></i>
                           </span>
                           <div class="rating-bar "></div>
                           <span class="total-count"><?php echo ($counts[5]) ? $counts[5] : '0'; ?></span>
                        </li>
                        <li>
                           <span>
                           4
                           <i class="fas fa-star"></i>
                           </span>
                           <div class="rating-bar "></div>
                           <span class="total-count"><?php echo ($counts[4]) ? $counts[4] : '0'; ?></span>
                        </li>
                        <li>
                           <span>
                           3
                           <i class="fas fa-star"></i>
                           </span>
                           <div class="rating-bar "></div>
                           <span class="total-count"><?php echo ($counts[3]) ? $counts[3] : '0'; ?></span>
                        </li>
                        <li>
                           <span>
                           2
                           <i class="fas fa-star"></i>
                           </span>
                           <div class="rating-bar "></div>
                           <span class="total-count"><?php echo ($counts[2]) ? $counts[2] : '0'; ?></span>
                        </li>
                        <li>
                           <span>
                           1
                           <i class="fas fa-star"></i>
                           </span>
                           <div class="rating-bar "></div>
                           <span class="total-count"><?php echo ($counts[1]) ? $counts[1] : '0'; ?></span>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="comments-box-body">
         <br>
         <div class="form-group control-with-label fixed-width">
            <label class="mb-0">Sort By:</label>
            <select class="form-control" id="order_by">
               <option value="desc">Newest</option>
               <option value="asc">Oldest</option>
            </select>
         </div>
         <ul class="comments-box-list mCustomScrollbar _mCS_1 mCS_no_scrollbar">
            <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0">
               <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
               </div>
               <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: none;">
                  <div class="mCSB_draggerContainer">
                     <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px;">
                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                     </div>
                     <div class="mCSB_draggerRail"></div>
                  </div>
               </div>
            </div>
         </ul>
      </div>

      <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
    <div id="review_form_wrapper">
      <div id="review_form">
        <?php
        $commenter    = wp_get_current_commenter();
        $comment_form = array(
          /* translators: %s is product title */
          'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
          /* translators: %s is product title */
          'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
          'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
          'title_reply_after'   => '</span>',
          'comment_notes_after' => '',
          'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
          'logged_in_as'        => '',
          'comment_field'       => '',
        );

        $name_email_required = (bool) get_option( 'require_name_email', 1 );
        $fields              = array(
          'author' => array(
            'label'    => __( 'Name', 'woocommerce' ),
            'type'     => 'text',
            'value'    => $commenter['comment_author'],
            'required' => $name_email_required,
          ),
          'email'  => array(
            'label'    => __( 'Email', 'woocommerce' ),
            'type'     => 'email',
            'value'    => $commenter['comment_author_email'],
            'required' => $name_email_required,
          ),
        );

        $comment_form['fields'] = array();

        foreach ( $fields as $key => $field ) {
          $field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
          $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

          if ( $field['required'] ) {
            $field_html .= '&nbsp;<span class="required">*</span>';
          }

          $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

          $comment_form['fields'][ $key ] = $field_html;
        }

        $account_page_url = wc_get_page_permalink( 'myaccount' );
        if ( $account_page_url ) {
          /* translators: %s opening and closing link tags respectively */
          $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
        }

        if ( wc_review_ratings_enabled() ) {
          $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
            <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
            <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
            <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
            <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
            <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
            <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
          </select></div>';
        }

        $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
        ?>
      </div>
    </div>
  <?php else : ?>
    <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
  <?php endif; ?>
   </div>

<style type="text/css">
 .pet-features-box.shadow-box {
    padding: 30px;
    height: calc(100% - 30px);
}
.pet-features-box {
    padding: 30px 0px;
}

.pet-features-box {
    font-size: 0.875rem;
}
.shadow-box {
    background: #f7f7f7;
    border-radius: 6px;
    box-shadow: 0px 1px 3.88px 0.12px rgb(0 0 0 / 12%);
    border: 1px solid #dddddd;
    padding: 28px 18px;
    margin-bottom: 30px;
}
.comments-box {
    padding-bottom: 11px;
    padding-top: 11px;
    text-align: center;
}
.comments-box .comments-box-header {
    display: flex;
}
.comments-box .comments-box-header > .row {
    flex: 1 1 auto;
}
.comments-box .comments-box-header .col-text {
    flex: 0 0 236px;
}
/*  .filter-star-rating {
    max-width: 320px;
} */
.star-rating-box {
    display: flex;
    align-items: center;
    color: #e7711b;
    font-size: 0.9em;
}
 .filter-star-rating .star-rating-box .star-rating-list {
    display: block;
    margin: 0px -10px;
    font-size: 12px;
    white-space: nowrap;
    width: 100%;
}
.filter-star-rating .star-rating-box .star-rating-list li {
    display: block;
    color: #404040;
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.star-rating-box .star-rating-list li {
    padding: 0px 2px;
}
.filter-star-rating .star-rating-box .star-rating-list li .rating-bar {
    flex: 1 1 auto;
    height: 10px;
    border-radius: 2px;
    background-color: #cecece;
}
 .filter-star-rating .star-rating-box .star-rating-list li span {
    padding: 0px 10px;
    opacity: 0.7;
    flex: 0 0 40px;
}

.shadow-box h5 {
	font-size: 1.73em;
    font-weight: 700;
    line-height: 1.2em;
    font-family: inherit;
}
</style>