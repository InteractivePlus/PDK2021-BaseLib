<?php
namespace InteractivePlus\PDK2021Core\Communication\CommunicationContents\Implementions\EmailTemplateContent;

use InteractivePlus\PDK2021Core\Base\Exception\ExceptionTypes\PDKInnerArgumentError;

class TemplateUtil{
    public static function renderTemplate(string $template, array $args, bool $replaceNullWithEmpty = true, bool $abortError = true) : string{
        //首先我们要处理variable list
        $newVariables = $args;
        //查找, 定位 {{ 以确定当前Variable位置
        $currentOffset = 0;
        
        $processedTemplate = $template;
        while($currentOffset < strlen($processedTemplate)){
            $nextVariableEnterZone = strpos($processedTemplate,'{{',$currentOffset);
            $nextVariableExitZone = strpos($processedTemplate,'}}',$currentOffset);
            if($nextVariableEnterZone === false || $nextVariableExitZone === false){
                break;
            }
            if($nextVariableExitZone < $nextVariableEnterZone){
                if($abortError){
                    $currentOffset = $nextVariableEnterZone;
                    continue;
                }else{
                    throw new PDKInnerArgumentError('template');
                }
            }
            $strippedVariableZone = substr(
                $processedTemplate,
                $nextVariableEnterZone + strlen('{{'),
                $nextVariableExitZone - $nextVariableEnterZone - strlen('{{')
            );
            $expressionVal = isset($args[$strippedVariableZone]) ? $args[$strippedVariableZone] : null;
            if($expressionVal === null){
                $expressionVal = $replaceNullWithEmpty ? '' : 'null';
            }
            $processedTemplate = substr_replace(
                $processedTemplate,
                $expressionVal,
                $nextVariableEnterZone,
                $nextVariableExitZone - $nextVariableEnterZone + strlen('}}')
            );
            $nextVariableExitZoneNewPtr = $nextVariableEnterZone + strlen($expressionVal);
            $currentOffset = $nextVariableExitZoneNewPtr;
        }
        return $processedTemplate;
    }
    public static function quickRender(string $template, array $args) : string{
        $renderedTpl = $template;
        foreach($args as $key => $val){
            $renderedTpl = str_replace('{{' . $key . '}}',$val, $renderedTpl);
        }
        return $renderedTpl;
    }
}