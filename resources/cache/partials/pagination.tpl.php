    <?php if (( $pagination->end_page > 1 )) { ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ((!empty( $pagination->first_page ))) { ?>
            <li class="page-item<?php if (( $pagination->page == $pagination->first_page )) { ?> disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $pagination->first_page; ?>">«</a></li>
            <?php } ?>                                    
            <?php if ((!empty( $pagination->previous_page ))) { ?>
            <li class="page-item<?php if (( $pagination->page == $pagination->previous_page )) { ?> disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $pagination->previous_page; ?>">&lt;</a></li>
            <?php } ?>
            <?php for ($p = $pagination->start_page; $p <= $pagination->end_page; $p++) { ?>
            <li class="page-item<?php if (( $pagination->page == $p )) { ?> disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a></li>
            <?php } ?>
            <?php if ((!empty( $pagination->next_page ))) { ?>
            <li class="page-item<?php if (( $pagination->page == $pagination->next_page )) { ?> disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $pagination->next_page; ?>">&gt;</a></li>
            <?php } ?>
            <?php if ((!empty( $pagination->last_page ))) { ?>
            <li class="page-item<?php if (( $pagination->page == $pagination->last_page )) { ?> disabled <?php } ?>"><a class="page-link" href="?page=<?php echo $pagination->last_page; ?>">»</a></li>
            <?php } ?>
        </ul>
    </nav>
    <?php } ?>
