<?php
class Subject {
    private $observers = [];

    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $this->observers = array_filter($this->observers, function($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notifyObservers($eventData) {
        foreach ($this->observers as $observer) {
            $observer->update($eventData);
        }
    }
}
?>