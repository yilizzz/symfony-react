import "./stimulus_bootstrap.js";
import { registerReactControllerComponents } from "@symfony/ux-react";
import "./styles/app.css";

// 这一行是核心：它告诉 Symfony 去哪里找你在 Twig 里调用的组件
registerReactControllerComponents(
    require.context("./react/controllers", true, /\.(j|t)sx?$/)
);
