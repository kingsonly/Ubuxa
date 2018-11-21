
            <div class="todo-list welll">
              <?php 
                $id = 1;
                if(!empty($tasks)){
                foreach ($tasks as $key => $value) { ?>
              <label class="todo">
                <?php if($value->status_id == $task::TASK_COMPLETED){ ?>
                    <input class="todo__state" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox" checked/>
                <?php }else { ?>
                    <input class="todo__state" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox"/>
                <?php } ?>
                
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon" id="task-box">
                  <use xlink:href="#todo__line" class="todo__line"></use>
                  <use xlink:href="#todo__box" class="todo__box"></use>
                  <use xlink:href="#todo__check" class="todo__check"></use>
                  <use xlink:href="#todo__circle" class="todo__circle"></use>
                </svg>

                <div class="todo__text">
                    <span><?= $value->title; ?></span>
                    
                </div>
                
              </label>

              <?php $id++;}}?>
            </div> 
