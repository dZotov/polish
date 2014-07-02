<?php

namespace Polish;

/**
 * Class CalcReversePolishException
 */
class CalcReversePolishException extends \Exception {

    //for custom Exception
}

/**
 * Class CalcReversePolish
 */
class CalcReversePolish {

    /**
     * Operations
     *
     * @var array
     */
    private $operations = array('*', '/', '+', '-');

    /**
     * Expression
     *
     * @var string
     */
    private $expression = null;

    /**
     * Errors
     *
     * @var array
     */
    private $errors = array(

        'not_enough_data'   => 'Not enough data in %s',
        'invalid_character' => 'Invalid character in %s',
        'empty_expression'  => 'Empty expression',
        'invalid_data'      => 'Invalid data'

    );

    /**
     * Constructor
     *
     * @param null $expression
     */
    function __construct($expression = null) {

        $this->expression = $expression;
    }

    /**
     *  Set Expression
     *
     * @param string $expression
     */
    public function setExpression($expression) {

        $this->expression = $expression;
    }

    /**
     * Get Expression
     *
     * @return string|null
     */
    public function getExpression() {

        return $this->expression;
    }

    /**
     * Calculate Reverse Polish
     *
     * @return bool|mixed
     * @throws CalcReversePolishException
     */
    public function calculate() {

        if (!$this->expression) {
            throw new CalcReversePolishException($this->errors['empty_expression']);
        }

        try {

            $stack = array();
            $token = strtok($this->expression, ' ');

            while ($token !== false) {

                if (in_array($token, $this->operations)) {

                    if (count($stack) < 2) {
                        throw new CalcReversePolishException(sprintf($this->errors['not_enough_data'], $stack));
                    }

                    $orepandA = array_pop($stack);
                    $orepandB = array_pop($stack);
                    switch ($token) {
                        case '*':
                            $result = $orepandA * $orepandB;
                            break;
                        case '/':
                            $result = $orepandA / $orepandB;
                            break;
                        case '+':
                            $result = $orepandA + $orepandB;
                            break;
                        case '-':
                            $result = $orepandA - $orepandB;
                            break;
                        default:
                            break;
                    }
                    array_push($stack, $result);

                } elseif (is_numeric($token)) {

                    array_push($stack, $token);

                } else {
                    throw new CalcReversePolishException(sprintf($this->errors['invalid_character'], $stack));
                }
                $token = strtok(' ');

            }
            if (count($stack) > 1) {
                throw new CalcReversePolishException(sprintf($this->errors['invalid_data'], $stack));
            }

            return array_pop($stack);

        } catch (CalcReversePolishException $ex) {
            echo 'Caught exception: ' . $ex->getMessage();
        }

        return false;
    }

}