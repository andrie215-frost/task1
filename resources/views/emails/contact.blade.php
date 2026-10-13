<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>SkillMatch Message</title>
</head>

<body
    style="
        margin: 0;
        padding: 0;
        background-color: #f4f7fb;
        font-family: Arial, Helvetica, sans-serif;
        color: #1f2937;
    "
>

    <table
        role="presentation"
        width="100%"
        cellspacing="0"
        cellpadding="0"
        style="padding: 32px 16px;"
    >

        <tr>

            <td align="center">

                <table
                    role="presentation"
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                    style="
                        max-width: 620px;
                        background: #ffffff;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        overflow: hidden;
                    "
                >

                    {{-- HEADER --}}
                    <tr>

                        <td
                            style="
                                background: #0f1d35;
                                padding: 22px 28px;
                                color: #ffffff;
                            "
                        >

                            <div
                                style="
                                    font-size: 22px;
                                    font-weight: 700;
                                "
                            >
                                SkillMatch
                            </div>

                            <div
                                style="
                                    margin-top: 4px;
                                    font-size: 13px;
                                    color: #cbd5e1;
                                "
                            >
                                Employment Matching Platform
                            </div>

                        </td>

                    </tr>


                    {{-- CONTENT --}}
                    <tr>

                        <td
                            style="
                                padding: 28px;
                            "
                        >

                            <p
                                style="
                                    margin: 0 0 18px;
                                    font-size: 16px;
                                    line-height: 1.6;
                                "
                            >
                                Hello {{ $recipientName }},
                            </p>


                            <p
                                style="
                                    margin: 0 0 20px;
                                    font-size: 15px;
                                    line-height: 1.7;
                                    color: #4b5563;
                                "
                            >
                                You received a message through SkillMatch.
                            </p>


                            {{-- CONTEXT --}}
                            <table
                                role="presentation"
                                width="100%"
                                cellspacing="0"
                                cellpadding="0"
                                style="
                                    margin-bottom: 22px;
                                    background: #f8fafc;
                                    border: 1px solid #e5e7eb;
                                    border-radius: 8px;
                                "
                            >

                                <tr>

                                    <td
                                        style="
                                            padding: 14px 16px;
                                            font-size: 14px;
                                            color: #6b7280;
                                        "
                                    >
                                        {{ $contextLabel }}
                                    </td>

                                    <td
                                        style="
                                            padding: 14px 16px;
                                            font-size: 14px;
                                            font-weight: 700;
                                            text-align: right;
                                        "
                                    >
                                        {{ $contextValue }}
                                    </td>

                                </tr>

                            </table>


                            {{-- MESSAGE --}}
                            <div
                                style="
                                    margin-bottom: 22px;
                                "
                            >

                                <div
                                    style="
                                        margin-bottom: 8px;
                                        font-size: 13px;
                                        font-weight: 700;
                                        color: #6b7280;
                                        text-transform: uppercase;
                                    "
                                >
                                    Message
                                </div>


                                <div
                                    style="
                                        padding: 16px;
                                        background: #f9fafb;
                                        border-left: 4px solid #2563eb;
                                        border-radius: 6px;
                                        font-size: 15px;
                                        line-height: 1.7;
                                        white-space: pre-line;
                                    "
                                >{{ $messageBody }}</div>

                            </div>


                            {{-- SENDER --}}
                            <div
                                style="
                                    margin-bottom: 22px;
                                    font-size: 14px;
                                    line-height: 1.7;
                                    color: #4b5563;
                                "
                            >

                                <strong>
                                    Sent by:
                                </strong>

                                {{ $senderName }}

                                <br>

                                <strong>
                                    Email:
                                </strong>

                                {{ $senderEmail }}

                            </div>


                            {{-- PROFILE LINK --}}
                            @if ($profileUrl)

                                <div
                                    style="
                                        margin-top: 24px;
                                    "
                                >

                                    <a
                                        href="{{ $profileUrl }}"
                                        style="
                                            display: inline-block;
                                            padding: 11px 18px;
                                            background: #2563eb;
                                            color: #ffffff;
                                            text-decoration: none;
                                            border-radius: 6px;
                                            font-size: 14px;
                                            font-weight: 700;
                                        "
                                    >
                                        View SkillMatch Profile
                                    </a>

                                </div>

                            @endif

                        </td>

                    </tr>


                    {{-- FOOTER --}}
                    <tr>

                        <td
                            style="
                                padding: 18px 28px;
                                background: #f8fafc;
                                border-top: 1px solid #e5e7eb;
                                font-size: 12px;
                                line-height: 1.6;
                                color: #6b7280;
                            "
                        >

                            This email was sent through SkillMatch.

                            <br>

                            You can reply directly to this message
                            using your email client.

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</body>

</html>