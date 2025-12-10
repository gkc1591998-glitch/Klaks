<style>

	@media only screen and (max-width: 768px) {
  
  .fs {
	line-height: 15px;
    font-size: 10px!important;
  }
}

</style>
<main class="site-main main-container no-sidebar">
    
    
    <div>
        <div class="container">
            <div class="akasha-heading style-01">
                <div class="heading-inner">
                    <h3 class="title"><?php echo (stripslashes(str_replace('\n','',$datas['name']))); ?></h3>
						
                </div>
            </div>
			
			<div class="akasha-heading style-01">
                <div class="heading-inner">
                    
						<div class="subtitle" style="font-size: 22px; font-weight: 600;">
                        General Queries
                    </div>
                </div>
            </div>
			
			<div class="row justify-content-center">
			<div class="col-lg-8 col-md-8 col-12 col-sm-12">
            <div class="akasha-blog style-01 justify-content-center">
                <div class="justify-content-center">
                    <?php 
                        $faqContent = isset($datas['content']) ? $datas['content'] : "";
                        $faqItems = [];
                        if ($faqContent) {
                            // Remove <br>, <br/>, <br /> and &nbsp; from the string
                            $faqContent = preg_replace('/<br\s*\/?>/i', "\n", $faqContent);
                            $faqContent = str_replace('&nbsp;', ' ', $faqContent);
                            // Remove all HTML tags
                            $faqContent = strip_tags($faqContent);
                            // Normalize line endings and remove leading/trailing whitespace
                            $faqContent = trim(str_replace(["\r\n", "\r"], "\n", $faqContent));
                            // Split by every Q- (case-insensitive, anywhere in the string)
                            $parts = preg_split('/Q-\s*/i', $faqContent);
                            foreach ($parts as $part) {
                                $part = trim($part);
                                if ($part === '') continue;
                                // Split by first A- (case-insensitive, must be at the start of a line)
                                $qa = preg_split('/^A-\s*/m', $part, 2);
                                $question = isset($qa[0]) ? trim($qa[0]) : '';
                                $answer = isset($qa[1]) ? trim($qa[1]) : '';
                                if ($question && $answer) {
                                    $faqItems[] = ["q" => $question, "a" => $answer];
                                }
                            }
                        }
                        ?>
                        <?php foreach($faqItems as $faq): ?>
                            <div class="details">
                            <details class="details__container">
                                <summary class="details__summary">
                                <h4 style="font-size: 14px" class="details__title"> <?php echo htmlspecialchars($faq['q']); ?></h4>
                                </summary>
                            </details>
                            <div class="details__desc">
                                <div class="details__desc-inner">
                                <?php echo nl2br(htmlspecialchars($faq['a'])); ?>
                                </div>
                            </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>
			</div>
			</div>
			
        </div>
    </div>
</main>