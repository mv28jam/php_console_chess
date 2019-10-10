<?php

class Rook extends AbstractFigure {
    
    /**
     * Price of Rook
     * @var integer 
     */
    public $price = 2;
    /**
     * Rook roque possible only like first step
     * @var boolean 
     */
    private $first_step = true;
    
    
    /**
     * Move Rook figure finally + rook actions
     * @param Move $move move object
     * @param Desk $desk 
     * @return AbstractFigure 
     */
    public function move(\Move $move, \Desk $desk) : AbstractFigure {
        
        parent::move($move, $desk);
        //first move done
        $this->first_step = false;
        //
        return $this;
    }
    
    /**
     * Validate Rook move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int {@inheritdoc}
     */
    public function checkFigureMove(Move $move, Desk $desk) : int 
    {
        //get possible moves
        $moves = $this->getVacuumHorsePossibleMoves($move);
        //ckeck our normal move
        foreach($moves[self::NORMAL] as $val){
            if($val->strTo === $move->strTo){
                //$this->checkStraightMoveBlock($move, $desk);
                return Move::FORBIDDEN;
            }
            //can not do such move
            return Move::FORBIDDEN;
        }
        //
        
        //
        return Move::FORBIDDEN;;
    }
    
    /**
     * Get list of possible moves from position start for rook
     * @param Move $move
     * @return array of array of Move 
     * @see AbstractFigure::getVacuumHorsePossibleMoves()
     */
    public function getVacuumHorsePossibleMoves(Move $move) :array
    {
        //ini
        $result = parent::getVacuumHorsePossibleMoves($move);
        //ordinary moves
        $result[self::NORMAL] = self::generateStraightMoves($move);
        //roque move without limitation
        switch(true){
            case($move->strFrom == 'h1' and $this->first_step):
                $result[self::SPECIAL][] = new Move('h1-f1');
                break;
            case($move->strFrom == 'a1' and $this->first_step):
                $result[self::SPECIAL][] = new Move('a1-d1');
                break;
            case($move->strFrom == 'h8' and $this->first_step):
                $result[self::SPECIAL][] = new Move('h8-f8');
                break;
            case($move->strFrom == 'a8' and $this->first_step):
                $result[self::SPECIAL][] = new Move('a8-d8');
                break;
        }
        //
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function __toString() : string 
    {
        return $this->is_black ? '♖' : '♜';
    }
    
    /**
     * Check horizontal or vertical move
     * @param Move $move Move object
     * @param Desk $desk 
     * @return int "price" of move / -1 = forbidden move / 0 = no attack move @see Move
     */
    public static function checkStraightMoveBlock(Move $move, Desk $desk) : bool 
    {
        //horiz or vertical move
        if($move->dY > 0){
            
        }else{
            
        }
        return false;
    }
    
    /**
     * Generate straight moves
     * @param Move $move
     * @return array of Move
     */
    public static function generateStraightMoves(Move $move){
        //array of moves
        $result = [];
        //
        for($i=1; $i<=8; $i++){
            //Y move
            $stepY = ($i - $move->yFrom);
            if($stepY != 0){
                $result[] = new Move($move->strFrom, $move->xFrom.($move->yFrom + $stepY));
            }
            // X move
            $stepX = ($i - $move->getXLikeY($move->xFrom));
            if($stepX != 0){
                $result[] = new Move($move->strFrom, $move->prevX($stepX).$move->yFrom);
            }
        }
        //
        return $result;
    }
   
}
