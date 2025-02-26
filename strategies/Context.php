<?php
class Context {
    private $strategy;

    public function setStrategy(SortStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function sortTareas(array $tareas): array {
        return $this->strategy->sort($tareas);
    }
}
?>